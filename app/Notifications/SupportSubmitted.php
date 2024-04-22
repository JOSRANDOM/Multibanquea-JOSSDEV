<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $name;
    protected $user_message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $name, string $user_message)
    {
        $this->name = $name;
        $this->user_message = $user_message;
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
            ->subject('¡Gracias por tu interés en ' . config('app.name') . '!')
            ->cc(env('MAIL_FROM_ADDRESS'))
            ->markdown('mail.support.submitted', [
                'name' => $this->name,
                'user_message' => $this->user_message,
            ]);
    }
}
