<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitSupportRequest;
use App\Notifications\SupportSubmitted;
use Illuminate\Support\Facades\Notification;

class SupportController extends Controller
{
    /**
     * Submit a support message.
     *
     * @param  \App\Http\Requests\SubmitSupportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(SubmitSupportRequest $request)
    {
        $validated = $request->validated();
        $name = $validated['name'];
        $email = $validated['email'];
        $user_message = $validated['user_message'];

        Notification::route('mail', $email)
            ->notify(new SupportSubmitted($name, $user_message));

        return redirect()->back();
    }
}
