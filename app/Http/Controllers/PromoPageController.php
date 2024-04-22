<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PromoPageController extends Controller
{
    /**
     * Show the promo page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(string $promo_code)
    {
        /**
         * Check if promo code is valid.
         */

        $plan = Plan::where('promo_code', $promo_code)
            ->where('active', true)
            ->where('public', true)
            ->first();

        if (!$plan) {
            return redirect()->route('welcome');
        }

        return view('promo.' . config('variant.name'), [
            'plan' => $plan,
        ]);
    }
}
