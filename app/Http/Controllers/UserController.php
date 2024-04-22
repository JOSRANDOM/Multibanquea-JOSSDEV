<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Requests\UpdateUserSlugRequest;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [
            'latest_registration' => User::all()->sortByDesc('created_at')->first()->created_at,
            'users' => User::paginate(50),
        ]);
    }

    /**
     * Update the user's name in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateName(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->name = $validated['name'];
        $user->save();

        return redirect()
            ->route('my-account.index')
            ->with('success', 'Tu nombre ha sido actualizado exitosamente.');
    }

    /**
     * Update the user's phone in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:10',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->phone = $validated['phone'];
        $user->save();

        return redirect()
            ->route('my-account.index')
            ->with('success', 'Tu teléfono ha sido actualizado exitosamente.');
    }

    /**
     * Update the user's slug in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSlug(UpdateUserSlugRequest $request)
    {
        $validated = $request->validated();

        /**
         * Update the user's slug.
         */

        $user = User::find($validated['user']);
        $user->slug = $validated['slug'];
        $user->save();

        /**
         * Update the user's plans, if the user is an affiliate.
         */

        if ($user->hasRole('affiliate')) {
            $plans = Plan::where('user_id', $user->id)->get();

            foreach ($plans as $plan) {
                $plan->promo_code = AffiliateController::generateAffiliatePlanPromoCode($user, $plan->months);
                $plan->updated_at = now();
                $plan->save();
            }
        }

        /**
         * Redirect back.
         */

        return redirect()
            ->back()
            ->with('success', 'El identificador público ha sido actualizado exitosamente.');
    }

    /**
     * Display a listing of non Premium users.
     *
     * @return \Illuminate\Http\Response
     */
    public function listNonPremium()
    {
        ini_set('memory_limit', -1);
        $premium_users_ids = DB::table('users')
            ->join('subscriptions', 'users.id', 'subscriptions.user_id')
            ->where('ends_at', '>=', now())
            ->where('starts_at', '<=', now())
            ->select('users.id')
            ->groupBy('users.id')
            ->pluck('id')
            ->toArray();

        $non_premium_users = User::whereNotIn('id', $premium_users_ids)->get();

        return view('admin.users.list-non-premium', [
            'users' => $non_premium_users,
        ]);
    }

    /**
     * Update the user's password in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request) {
        $validated = $request->validate([
            'current-password' => ['required'],
            'new-password' => ['required','min:4'],
            'new-confirm-password' => ['same:new-password']
        ]);

        if(Hash::check($validated['current-password'], Auth::user()->getAuthPassword())) {
            $user = User::findOrFail(Auth::id());
            $user->password =  Hash::make($validated['new-password']);
            $user->save();
        }
        return redirect()
            ->route('my-account.index')
            ->with('success', 'Tu contraseña ha sido actualizada exitosamente.');
    }
}
