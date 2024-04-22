<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\OAuthUser;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Notifications\EmailLinkRequested;
use App\Notifications\EmailLinkSucceeded;
use App\Notifications\UserRegistered;
use App\Notifications\WelcomeNewUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthUserController extends Controller
{
    /**
     * Log the user in.
     * 
     * @param \App\Models\User $user
     */
    private function loginUser(User $user)
    {
        Auth::login($user);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_LOGGED_IN')->first()->id,
        ]);
    }

    /**
     * Notify that a user has registered.
     *
     * @param \App\Models\User $user
     */
    private function notifyUserRegistration(User $user)
    {
        Notification::route('slack', config('slack.webhook'))->notify(new UserRegistered($user));

        $user->notify(new UserRegistered($user));

        // Envía un correo electrónico de bienvenida al nuevo usuario
        $user->notify(new WelcomeNewUser($user));
    }

    /**
     * Register the user.
     * 
     * @param $oauth_user
     */
    private function registerUser($o_auth_user)
    {
        $user = User::create([
            "name" => $o_auth_user->name,
            "email" => $o_auth_user->email,
            "password" => Hash::make(Str::random(12)),
            "utm_source" => Cookie::get('utm_source'),
            "utm_medium" => Cookie::get('utm_medium'),
            "utm_campaign" => Cookie::get('utm_campaign'),
            "utm_term" => Cookie::get('utm_term'),
            "utm_content" => Cookie::get('utm_content'),
        ]);

        $user->slug = rand(1000, 9999) . $user->id;
        $user->save();
        $user->o_auth_users()->save($o_auth_user);
        $this->notifyUserRegistration($user);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_REGISTERED')->first()->id,
        ]);
    }

    /**
     * Redirect the user to the OAuth provider authentication page.
     *
     * @param String $provider The OAuth provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from OAuth provider.
     *
     * @param String $provider The OAuth provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(string $provider)
    {
        /**
         * Get the OAuth user data.
         */

        $provider_user_data = Socialite::driver($provider)->stateless()->user();
        $o_auth_user = new OAuthUser;
        $o_auth_user->provider = $provider;
        $o_auth_user->provider_id = $provider_user_data->getId();
        $o_auth_user->nickname = $provider_user_data->getNickname();
        $o_auth_user->name = $provider_user_data->getName();
        $o_auth_user->email = $provider_user_data->getEmail();
        $o_auth_user->avatar = $provider_user_data->getAvatar();

        /**
         * Check if OAuth user already exists in the database.
         * If it exists, update its data if new data is available.
         * Otherwise, store the new OAuth user in the database.
         */

        $o_auth_user_in_db = OAuthUser::where('provider', $o_auth_user->provider)
            ->where('provider_id', $o_auth_user->provider_id)
            ->first();

        $o_auth_user_is_in_db = !!$o_auth_user_in_db;

        if ($o_auth_user_is_in_db) {
            $o_auth_user_in_db->nickname = $o_auth_user_in_db->nickname ?? $o_auth_user->nickname;
            $o_auth_user_in_db->name = $o_auth_user_in_db->name ?? $o_auth_user->name;
            $o_auth_user_in_db->email = $o_auth_user_in_db->email ?? $o_auth_user->email;
            $o_auth_user_in_db->avatar = $o_auth_user_in_db->avatar ?? $o_auth_user->avatar;
            $o_auth_user_in_db->save();

            $o_auth_user = $o_auth_user_in_db;
        } else {
            $o_auth_user->save();
        }

        /**
         * Check if OAuth user is already linked to a user.
         */

        $o_auth_user_is_linked_to_user = !!$o_auth_user->user;

        if ($o_auth_user_is_linked_to_user) {
            $this->loginUser($o_auth_user->user);
            return redirect()->intended();
        }

        /**
         * Attempt to link OAuth user to user with email.
         */

        $o_auth_user_has_email = !!$o_auth_user->email;

        if ($o_auth_user_has_email) {
            $user_with_o_auth_user_email = User::where('email', $o_auth_user->email)->first();

            $user_with_o_auth_user_email_exists = !!$user_with_o_auth_user_email;

            if ($user_with_o_auth_user_email_exists) {
                $user_with_o_auth_user_email->o_auth_users()->save($o_auth_user);
            } else {
                $this->registerUser($o_auth_user);
            }

            $o_auth_user->refresh();
            $this->loginUser($o_auth_user->user);
            return redirect()->intended();
        }

        /**
         * Generate request token.
         */

        $o_auth_user->email_requested_request_token = Str::random(24);
        $o_auth_user->save();

        /**
         * Show view to prompt user to enter their email to link it.
         */

        return redirect()->route('register.showLinkEmailForm', [
            'o_auth_user' => $o_auth_user,
            'email_requested_request_token' => $o_auth_user->email_requested_request_token,
        ]);
    }

    /**
     * Show the form for linking an email to an OAuth user.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkEmailForm($o_auth_user_id, $email_requested_request_token)
    {
        $o_auth_user = OAuthUser::findOrFail($o_auth_user_id);

        /**
         * Check validity of request token.
         */

        $request_token_is_valid = $o_auth_user->email_requested_request_token === $email_requested_request_token;

        if (!$request_token_is_valid) {
            abort(404);
        }

        return view('auth.register.link-email', [
            'o_auth_user' => $o_auth_user,
            'email_requested_request_token' => $o_auth_user->email_requested_request_token,
        ]);
    }

    /**
     * Requests email confirmation to start email linking.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestLinkingEmail(Request $request, $o_auth_user_id, $email_requested_request_token)
    {
        $o_auth_user = OAuthUser::findOrFail($o_auth_user_id);

        /**
         * Check validity of request token.
         */

        $request_token_is_valid = $o_auth_user->email_requested_request_token === $email_requested_request_token;

        if (!$request_token_is_valid) {
            abort(404);
        }

        /**
         * Validate email.
         */

        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        /**
         * Check that user doesn't have already an email.
         */

        if (!!$o_auth_user->email) {
            abort(500);
        }

        /**
         * Generate response token and remove request token.
         */

        $o_auth_user->email_requested = $validated['email'];
        $o_auth_user->email_requested_request_token = null;
        $o_auth_user->email_requested_response_token = Str::random(24);
        $o_auth_user->email_requested_response_token_created_at = now();
        $o_auth_user->save();

        /**
         * Send verification email.
         */

        Notification::route('mail', $validated['email'])
            ->notify(new EmailLinkRequested($o_auth_user, $validated['email']));

        /**
         * Redirect to instructions page.
         */

        return view('auth.register.link-email-confirmation', [
            'email' => $validated['email'],
        ]);
    }

    /**
     * Link email to OAuth user.
     *
     * @return \Illuminate\Http\Response
     */
    public function linkEmail($o_auth_user_id, $email_requested_response_token)
    {
        $o_auth_user = OAuthUser::findOrFail($o_auth_user_id);

        /**
         * Check validity of response token.
         */

        $response_token_is_valid = $o_auth_user->email_requested_response_token === $email_requested_response_token;

        if (!$response_token_is_valid) {
            abort(404);
        }

        /**
         * Check that user doesn't have already an email.
         */

        if (!!$o_auth_user->email) {
            abort(500);
        }

        /**
         * Check token expiration.
         */

        $oldest_valid_date = Carbon::now()->subHours(12);
        $token_created_at = $o_auth_user->email_requested_response_token_created_at;
        $token_is_valid = $token_created_at > $oldest_valid_date;

        if (!$token_is_valid) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'La solicitud ha expirado. Por favor ingresa nuevamente.');
            return redirect()->route('login')->with('errors', $messageBag);
        }

        /**
         * Update OAuth user: Link to email address and remove response token.
         */

        $o_auth_user->email = $o_auth_user->email_requested;
        $o_auth_user->email_requested = null;
        $o_auth_user->email_requested_response_token = null;
        $o_auth_user->email_requested_response_token_created_at = null;
        $o_auth_user->save();
        $o_auth_user->refresh();

        /**
         * Send confirmation notifications.
         */

        Notification::route('mail', $o_auth_user->email)->notify(new EmailLinkSucceeded($o_auth_user));
        Notification::route('slack', config('slack.webhook'))->notify(new EmailLinkSucceeded($o_auth_user));

        /**
         * Redirect to login page.
         */

        return redirect()->route('login')->with('success', '¡Tu correo electrónico ha sido verificado exitosamente! Por favor ingresa nuevamente.');
    }
}
