<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Generate an affiliate plan unique promo code.
     *
     * @param \Illuminate\Http\User  $affiliate
     * @param int                    $months
     * @return string
     */
    public static function generateAffiliatePlanPromoCode(User $user, int $months)
    {
        $promo_code_base = Str::upper(Str::slug($user->slug . $months));

        if (Plan::where('promo_code', $promo_code_base)->count() == 0) {
            return $promo_code_base;
        }

        $promo_code = '';

        do {
            $promo_code = $promo_code_base . '-' . Str::upper(Str::slug(Str::random(5)));
        } while (Plan::where('slug', $promo_code)->count() > 0);

        return $promo_code;
    }

    /**
     * Generate an affiliate plan unique slug.
     *
     * @return string
     */
    private function generateAffiliatePlanSlug()
    {
        $slug = '';

        do {
            $slug = Str::slug(Str::random(20));
        } while (Plan::where('slug', $slug)->count() > 0);

        return $slug;
    }

    /**
     * Create or activate plans for the affiliate user.
     */
    private function activateAffiliatePlans(User $user)
    {
        $months_plans = 12; // Plans are created for all months, from 1 to 12.

        for ($months = 1; $months <= $months_plans; $months++) {
            $plan = $user->plans->where('months', $months)->first();

            if (!$plan) {
                $monthly_price = DB::table('affiliate_plans_prices')
                    ->select('monthly_price')
                    ->where('months', $months)
                    ->pluck('monthly_price')
                    ->first();

                $plan = Plan::create([
                    'slug' => $this->generateAffiliatePlanSlug(),
                    'promo_code' => $this->generateAffiliatePlanPromoCode($user, $months),
                    'user_id' => $user->id,
                    'name' => 'Acceso total',
                    'months' => $months,
                    'monthly_price' => $monthly_price,
                    'active' => true,
                    'public' => true,
                    'protected' => false,
                    'featured' => false,
                ]);
            } else {
                $plan->active = true;
                $plan->updated_at = now();
                $plan->save();
            }
        }
    }

    /**
     * Deactivate plans for the affiliate user.
     */
    private function deactivateAffiliatePlans(User $user)
    {
        foreach ($user->plans as $plan) {
            $plan->active = false;
            $plan->updated_at = now();
            $plan->save();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Get users with "affiliate" role.
         */

        $affiliates = User::role('affiliate')->get()->sortBy('name');

        /**
         * Get affiliates' analytics.
         */
        $affiliates_ids = User::role('affiliate')->pluck('id')->toArray();
        $analytics = DB::table('plans')
            ->leftJoin('affiliate_clicks_analytics', 'affiliate_clicks_analytics.plan_id', 'plans.id')
            ->leftJoin('subscriptions', 'subscriptions.plan_id', 'plans.id')
            ->whereIn('plans.user_id', $affiliates_ids)
            ->select(
                'plans.user_id',
                DB::raw('COUNT(DISTINCT affiliate_clicks_analytics.id) AS clicks'),
                DB::raw('COUNT(DISTINCT subscriptions.id) AS subscriptions'),
            )
            ->groupBy('plans.user_id')
            ->get();

        /**
         * Display view.
         */

        return view('admin.affiliates.index', [
            'affiliates' => $affiliates,
            'analytics' => $analytics,
        ]);
    }

    /**
     * Add the "affiliate" role to a user.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|exists:users,id',
        ]);

        $user = User::find($validated['user']);
        $user->assignRole('affiliate');

        $this->activateAffiliatePlans($user);

        return redirect()
            ->back()
            ->with('success', $user->name . ' (ID: ' . $user->id . ') ha sido agregado como afiliado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|exists:users,id',
            'active' => 'required|boolean',
        ]);

        if (!$validated['active']) {
            $user = User::find($validated['user']);
            $user->removeRole('affiliate');
            $user->save();

            $this->deactivateAffiliatePlans($user);

            return redirect()
                ->back()
                ->with('success', $user->name . ' (ID: ' . $user->id . ') ha sido removido del programa de afiliados.');
        }

        return redirect()->back();
    }
}
