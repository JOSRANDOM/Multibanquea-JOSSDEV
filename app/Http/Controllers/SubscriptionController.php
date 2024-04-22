<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\CheckoutReference;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Notifications\ChargebackReceived;
use App\Notifications\PaymentReceived;
use App\Notifications\UserSubscribed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

use MercadoPago;

class SubscriptionController extends Controller
{
    /**
     * Calculates a subscription's start and end for a user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plan  $plan
     * @return array
     */
    private function getSubscriptionStartAndEnd(User $user, Plan $plan)
    {
        $user_active_subscription = $user->active_subscriptions->sortByDesc('ends_at')->first();

        if (is_null($user_active_subscription)) {
            $start = Carbon::now();
        } else {
            $start = $user_active_subscription->ends_at;
        }

        $end = $start->copy()->addMonths($plan->months);

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * Creates and returns a Mercado Pago preference.
     *
     * @param  \App\Models\Plan  $plan
     * @param  \App\Models\CheckoutReference  $checkout_reference
     * @return \MercadoPago\Preference
     */
    private function getMercadoPagoPreference(Plan $plan, CheckoutReference $checkout_reference)
    {
        MercadoPago\SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $external_reference = strval($checkout_reference->id);
        $total_price = $plan->monthly_price * $plan->months / 100;

        $item = new MercadoPago\Item();
        $item->title = config('app.name') . ': ' . trans_choice('generic.month', $plan->months);
        $item->category_id = "virtual_goods";
        $item->quantity = 1;
        $item->currency_id = "PEN";
        $item->unit_price = $total_price;
        $preference->items = array($item);

        $preference->back_urls = array(
            "success" => route('subscriptions.index'),
            "failure" => route('subscriptions.index'),
            "pending" => route('subscriptions.index'),
        );
        $preference->auto_return = "approved";
        $preference->statement_descriptor = config('app.name');
        $preference->external_reference = $external_reference;

        $preference->save();

        return $preference;
    }

    /**
     * Display the main subscriptions overview page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('subscriptions.index');
    }

    /**
     * Show the checkout form.
     *
     * @param  string  $plan_slug
     * @return \Illuminate\Http\Response
     */
    public function checkout(string $plan_slug)
    {
        $plan = Plan::where('slug', $plan_slug)
            ->where('active', true)
            ->where('public', true)
            ->first();

        if (!$plan) {
            return redirect()->route('subscriptions.index');
        }

        $subscription_start_and_end = $this->getSubscriptionStartAndEnd(Auth::user(), $plan);
        $subscription_starts_at = $subscription_start_and_end['start'];
        $subscription_ends_at = $subscription_start_and_end['end'];

        /**
         * Set checkout reference.
         */
        // dd('s');
        // $checkout_reference = app(CheckoutReferenceController::class)->store(Auth::user(), $plan);
        $user = Auth::user();

        $checkout_reference = CheckoutReference::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'total_price' => $plan->monthly_price * $plan->months,
            'amount_paid' => 0,
        ]);

        // dd('s');
        $preference = $this->getMercadoPagoPreference($plan, $checkout_reference);

        return view('subscriptions.checkout', [
            'mercado_pago_preference_init_point' => $preference->init_point,
            'plan' => $plan,
            'subscription_starts_at' => $subscription_starts_at,
            'subscription_ends_at' => $subscription_ends_at,
        ]);
    }

    //NUEVA FUNCION PARA DESCUENTOS A NUEVOS USUARIO

    public function NewUserPromo()
    {
        // Buscar el plan con el slug predeterminado
        $plan_slug = "1-mes-promo-new-user";
        $plan = Plan::where('slug', $plan_slug)
                    ->where('active', true)
                    ->where('public', true)
                    ->first();
    
        if (!$plan) {
            return redirect()->route('subscriptions.index');
        }
    
        // Obtener fechas de inicio y fin de la suscripción
        $subscription_start_and_end = $this->getSubscriptionStartAndEnd(Auth::user(), $plan);
        $subscription_starts_at = $subscription_start_and_end['start'];
        $subscription_ends_at = $subscription_start_and_end['end'];
    
        // Crear una referencia de compra
        $user = Auth::user();
        $checkout_reference = CheckoutReference::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'total_price' => $plan->monthly_price * $plan->months,
            'amount_paid' => 0,
        ]);
    
        // Obtener la preferencia de MercadoPago
        $preference = $this->getMercadoPagoPreference($plan, $checkout_reference);
    
        // Devolver la vista con los datos necesarios
        return view('subscriptions.checkout', [
            'mercado_pago_preference_init_point' => $preference->init_point,
            'plan' => $plan,
            'subscription_starts_at' => $subscription_starts_at,
            'subscription_ends_at' => $subscription_ends_at,
        ]);
    }

    /**
     * Log a response from the IPN API for debugging and responds with a HTTP
     * response.
     *
     * @param integer $http_code
     * @param string $message
     * @param string $id  IPN ID
     * @param string $topic  IPN topic
     * @return \Illuminate\Http\Response
     */
    private function apiIpnLogAndRespond($content, $status, $id, $topic)
    {
        Log::debug('API IPN: ' . $status . ' ' . $content . ' (' . $topic . ' #' . $id . ')');
        return response($content, $status);
    }

    /**
     * Receives and processes an IPN (Instant Payment Notification) from
     * Mercado Pago.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiIpn(Request $request)
    {
        /**
         * Log basic request information.
         */

        $uuid = Str::uuid();
        Log::debug('(' . $uuid . ') API IPN: Requested: ' . $request->fullUrl());

        $data = $request->all();
        $ipn_id = $data['data_id'];
        $ipn_topic = $data['type'];

        /**
         * Check if payload is valid.
         */

        $topic_is_valid = $ipn_topic === 'chargebacks' || $ipn_topic === 'payment' || $ipn_topic === 'merchant_order';

        if (!$topic_is_valid || !$ipn_id) {
            return $this->apiIpnLogAndRespond('Invalid payload', 400, $ipn_id, $ipn_topic);
        }

        /**
         * Initialize Mercado Pago SDK.
         */

        MercadoPago\SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        /**
         * Check if IPN is a chargeback.
         */

        if ($ipn_topic === "chargebacks") {
            $chargeback = MercadoPago\Chargeback::find_by_id($ipn_id);

            if (!$chargeback) {
                return $this->apiIpnLogAndRespond('Chargeback not found', 400, $ipn_id, $ipn_topic);
            }

            Notification::route('slack', env('SLACK_WEBHOOK_URL'))
                ->notify(new ChargebackReceived($ipn_id, $ipn_topic));

            return $this->apiIpnLogAndRespond('Chargeback stored but needs manual processing', 200, $ipn_id, $ipn_topic);
        }

        /**
         * Check if IPN is a payment.
         */

        if ($ipn_topic === "payment") {
            $payment = MercadoPago\Payment::find_by_id($ipn_id);

            if (!$payment) {
                return $this->apiIpnLogAndRespond('Payment not found', 400, $ipn_id, $ipn_topic);
            }

            $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);

            if (!$merchant_order) {
                return $this->apiIpnLogAndRespond('Merchant order not found', 400, $ipn_id, $ipn_topic);
            }
        }

        /**
         * Check if IPN is a merchant order.
         */

        if ($ipn_topic === "merchant_order") {
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($ipn_id);

            if (!$merchant_order) {
                return $this->apiIpnLogAndRespond('Merchant order not found', 400, $ipn_id, $ipn_topic);
            }
        }

        /**
         * Calculate paid amount.
         */

        $paid_amount = 0;

        foreach ($merchant_order->payments as $payment) {
            if ($payment->status == 'approved') {
                $paid_amount += $payment->transaction_amount;
            }
        }

        $amount_paid_integer = intval($paid_amount * 100);

        /**
         * Check if there is no approved payment yet.
         */
        if (!$amount_paid_integer) {
            return $this->apiIpnLogAndRespond('No approved payment yet', 200, $ipn_id, $ipn_topic);
        }

        /**
         * Check if checkout reference was already fully paid.
         */

        $checkout_reference = CheckoutReference::find($merchant_order->external_reference);

        if (!$checkout_reference) {
            return $this->apiIpnLogAndRespond('Checkout reference not found', 400, $ipn_id, $ipn_topic);
        }

        if ($checkout_reference->isPaid()) {
            return $this->apiIpnLogAndRespond('Already fully paid', 200, $ipn_id, $ipn_topic);
        }

        /**
         * Update checkout reference.
         */

        $checkout_reference->amount_paid = $amount_paid_integer;
        $checkout_reference->save();

        /**
         * Check if it's NOW fully paid and activate Premium account.
         */

        $user = User::find($checkout_reference->user_id);

        if ($checkout_reference->isPaid()) {
            $subscription_start_and_end = $this->getSubscriptionStartAndEnd($checkout_reference->user, $checkout_reference->plan);
            $subscription_starts_at = $subscription_start_and_end['start'];
            $subscription_ends_at = $subscription_start_and_end['end'];

            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $checkout_reference->plan->id,
                'starts_at' => $subscription_starts_at,
                'ends_at' => $subscription_ends_at,
            ]);

            UserActivityLog::create([
                'user_id' => $user->id,
                'activity_type_id' => ActivityType::where('name', 'USER_CREATED_SUBSCRIPTION')->first()->id,
                'object_id' => $subscription->id,
            ]);

            Notification::route('slack', env('SLACK_WEBHOOK_URL'))
                ->notify(new PaymentReceived($checkout_reference, $subscription, $ipn_id));

            $user->notify(new PaymentReceived($checkout_reference, $subscription, $ipn_id));
            $user->notify(new UserSubscribed($subscription));
        } else {
            Notification::route('slack', env('SLACK_WEBHOOK_URL'))
                ->notify(new PaymentReceived($checkout_reference, null, $ipn_id));

            $user->notify(new PaymentReceived($checkout_reference, null, $ipn_id));
        }

        return $this->apiIpnLogAndRespond('Successfully processed', 201, $ipn_id, $ipn_topic);
    }

    /**
     * Show the form for creating a subscription for a given user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $plans = Plan::where('active', true)
            ->where('public', false)
            ->get();

        return view('admin.users.create-subscription', [
            'plans' => $plans,
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'starts_at' => 'required|date',
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::find($validated['plan_id']);

        $plan_is_valid = $plan->active && !$plan->public;

        if (!$plan_is_valid) {
            $messageBag = new MessageBag;
            $messageBag->add('error', 'El plan escogido no es válido. Debe estar activo y ser privado.');
            return redirect()->back()->with('errors', $messageBag);
        }

        $starts_at = new Carbon($validated['starts_at']);
        $ends_at = $starts_at->copy()->addMonths($plan->months);

        $subscriptions_intersected = $user->subscriptions
            ->where('starts_at', '<', $ends_at)
            ->where('ends_at', '>', $starts_at);
        $intersects_another_subscription = !!$subscriptions_intersected->count();

        if ($intersects_another_subscription) {
            $first_subscription_intersected = $subscriptions_intersected->first();
            $messageBag = new MessageBag;
            $messageBag->add('error', 'Las fechas de inicio y fin indicadas (del ' . $starts_at . ' al ' . $ends_at . ') entran en conflicto con otra suscripción existente del ' . $first_subscription_intersected->starts_at . ' al ' . $first_subscription_intersected->ends_at . '.');
            return redirect()->back()->with('errors', $messageBag);
        }

        $subscription = new Subscription([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
        ]);

        $user->subscriptions()->save($subscription);
        $user->notify(new UserSubscribed($subscription));

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Subscription $subscription)
    {
        return view('admin.users.edit-subscriptions', [
            'subscription' => $subscription,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Subscription $subscription)
    {
        $validated = $request->validate([
            'starts_at' => 'required|date',
        ]);

        $starts_at = new Carbon($validated['starts_at']);
        $ends_at = $starts_at->copy()->addMonths($subscription->plan->months);

        $subscriptions_intersected = $user->subscriptions
            ->where('starts_at', '<', $ends_at)
            ->where('ends_at', '>', $starts_at)
            ->where('id', '<>', $subscription->id);
        $intersects_another_subscription = !!$subscriptions_intersected->count();

        if ($intersects_another_subscription) {
            $first_subscription_intersected = $subscriptions_intersected->first();
            $messageBag = new MessageBag;
            $messageBag->add('error', 'Las fechas de inicio y fin indicadas (del ' . $starts_at . ' al ' . $ends_at . ') entran en conflicto con otra suscripción existente del ' . $first_subscription_intersected->starts_at . ' al ' . $first_subscription_intersected->ends_at . '.');
            return redirect()->back()->with('errors', $messageBag);
        }

        $subscription->starts_at = $starts_at;
        $subscription->ends_at = $ends_at;
        $subscription->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
