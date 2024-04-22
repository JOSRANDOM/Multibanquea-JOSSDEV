<?php

namespace App\Http\Controllers;

use App\Models\User;

class AffiliateController extends Controller
{
    /**
     * Show the affiliate program landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('affiliate.index');
    }

    /**
     * Show the affiliate general page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(string $slug)
    {
        $affiliate = User::where('slug', $slug)->firstOrFail();

        return view('affiliate.' . config('variant.name') . '.show', [
            'affiliate' => $affiliate,
        ]);
    }
}
