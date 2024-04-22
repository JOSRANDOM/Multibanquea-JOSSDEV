<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    /**
     * Add a subscription to a user.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        /**
         * Validate form input.
         */
        // dd($request->all());

        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in([
                    'afiliados',
                    'afiliados-cursos',
                    'colaborador',
                    'pago-manual',
                    'sorteo',
                    'trabajador',
                ]),
            ],
            'months' => 'required|numeric|min:1|max:12',
        ]);

        /**
         * Calculate subscription start.
         */

        $user_active_subscription = $user->active_subscriptions->sortByDesc('ends_at')->first();


        if (is_null($user_active_subscription)) {
            $starts_at = Carbon::now();
        } else {
            $starts_at = $user_active_subscription->ends_at;
        }

        /**
         * Calculate subscription end.
         */

        $ends_at = $starts_at->copy()->addMonths($validated['months']);

        /**
         * Create subscription.
         */
        $plan = Plan::where('slug', $validated['type'])->first();
        if($plan){
            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'starts_at' => $starts_at,
                'ends_at' => $ends_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return redirect()->route('admin.users.show',['user'=>$user->id])
            ->with('success', 'Se agrego subscripçión con éxito');
        }else{
            return redirect()->route('admin.users.show',['user'=>$user->id])
            ->with('error', 'El plan que quieres asociar no existe');
        }
        // dd($plan,$starts_at,$ends_at);
        // $plan_id = Plan::where('slug', $validated['type'])->firstOrFail()->id;



        // return redirect()->back();
    }
}
