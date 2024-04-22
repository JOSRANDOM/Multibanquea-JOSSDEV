<?php

namespace App\Http\Middleware;

use App\Models\Plan;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class StoreAffiliateClicksAnalytics
{
    /**
     * Add a click to an affiliate link's analytics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route_name = $request->route()->getName();

        switch ($route_name) {
            case 'affiliates.show':
                $user_slug = $request->route('slug');
                $user = User::where('slug', $user_slug)->firstOrFail();

                DB::table('affiliate_clicks_analytics')->insert([
                    'user_id' => $user->id,
                    'url' => URL::current(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                break;

            case 'promo.show':
                $promo_code = $request->route('promo_code');
                $plan = Plan::where('promo_code', $promo_code)->firstOrFail();

                if ($plan->user) {
                    DB::table('affiliate_clicks_analytics')->insert([
                        'user_id' => $plan->user->id,
                        'plan_id' => $plan->id,
                        'url' => URL::current(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                break;

            default:
                break;
        }

        return $next($request);
    }
}
