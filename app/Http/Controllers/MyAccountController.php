<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyAccountController extends Controller
{
    /**
     * Display the "my account" page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        $analytics = DB::table('plans')
            ->leftJoin('affiliate_clicks_analytics', 'affiliate_clicks_analytics.plan_id', 'plans.id')
            ->leftJoin('subscriptions', 'subscriptions.plan_id', 'plans.id')
            ->where('plans.user_id', $user->id)
            ->select(
                'plans.months',
                DB::raw('plans.id AS plan_id'),
                DB::raw('COUNT(DISTINCT affiliate_clicks_analytics.id) AS clicks'),
                DB::raw('COUNT(DISTINCT subscriptions.id) AS subscriptions'),
            )
            ->groupBy('plans.id')
            ->orderBy('plans.months')
            ->get();

        return view('my-account', [
            'analytics' => $analytics,
            'user' => $user,
        ]);
    }
}
