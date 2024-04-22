<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class VerifyAffiliateLink
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
        $user_slug = $request->route('slug');
        $user = User::where('slug', $user_slug)->first();

        if (!$user || !$user->hasRole('affiliate')) {
            return redirect('/');
        }

        return $next($request);
    }
}
