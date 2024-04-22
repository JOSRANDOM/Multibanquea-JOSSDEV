<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class StoreUtmParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $cookie_duration_minutes = 10080; // 7 days

        $utm_source = $request->query('utm_source');
        $utm_medium = $request->query('utm_medium');
        $utm_campaign = $request->query('utm_campaign');
        $utm_term = $request->query('utm_term');
        $utm_content = $request->query('utm_content');

        if ($utm_source) {
            Cookie::queue('utm_source', $utm_source, $cookie_duration_minutes);
        }

        if ($utm_medium) {
            Cookie::queue('utm_medium', $utm_medium, $cookie_duration_minutes);
        }

        if ($utm_campaign) {
            Cookie::queue('utm_campaign', $utm_campaign, $cookie_duration_minutes);
        }

        if ($utm_term) {
            Cookie::queue('utm_term', $utm_term, $cookie_duration_minutes);
        }

        if ($utm_content) {
            Cookie::queue('utm_content', $utm_content, $cookie_duration_minutes);
        }

        return $next($request);
    }
}
