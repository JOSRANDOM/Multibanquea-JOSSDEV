<?php

namespace App\Notifications;

use App\Models\OAuthUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class EmailLinkSucceeded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $o_auth_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(OAuthUser $o_auth_user)
    {
        $this->o_auth_user = $o_auth_user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'mail',
            'slack',
        ];
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
            ->subject('Tu correo electrónico ha sido verificado')
            ->bcc(config('mail.from.address'))
            ->markdown('mail.user.email-link-succeeded', [
                'o_auth_user' => $this->o_auth_user,
            ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Message\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from(config('app.name'), ':link:')
            ->to(config('slack.channels.monitoring'))
            ->content('Correo electrónico vinculado a cuenta de usuario')
            ->attachment(function ($attachment) {
                $attachment->title('Usuario')
                    ->fields([
                        'Nombre' => $this->o_auth_user->name,
                        'Correo electrónico' => $this->o_auth_user->email,
                        'Autenticado con' => $this->o_auth_user->provider,
                        'ID (o_auth_user)' => $this->o_auth_user->id,
                    ]);
            });
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
