<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckoutReference;
use App\Models\Plan;
use App\Models\User;

class CheckoutReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.checkout-references.index', [
            'checkout_references' => CheckoutReference::orderBy('id', 'desc')->paginate(50),
            'latest_checkout_reference' => CheckoutReference::orderBy('updated_at', 'desc')->first()->created_at,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Plan $plan)
    {
        $checkout_reference = CheckoutReference::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'total_price' => $plan->monthly_price * $plan->months,
            'amount_paid' => 0,
        ]);

        return $checkout_reference;
    }
}
