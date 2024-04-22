<?php

namespace App\Notifications;

use App\Models\OAuthUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailLinkRequested extends Notification implements ShouldQueue
{
    use Queueable;

    protected $o_auth_user;
    protected $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(OAuthUser $o_auth_user, $email)
    {
        $this->o_auth_user = $o_auth_user;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifica tu correo electrónico')
            ->bcc(config('mail.from.address'))
            ->markdown('mail.user.email-link-requested', [
                'o_auth_user' => $this->o_auth_user,
                'email' => $this->email,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
