<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ChargebackReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ipn_id;
    protected $ipn_topic;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ipn_id, $ipn_topic)
    {
        $this->ipn_id = $ipn_id;
        $this->ipn_topic = $ipn_topic;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
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
            ->from(config('app.name'), ':exclamation:')
            ->to(env('SLACK_CHANNEL_PAYMENTS'))
            ->content('¡Nuevo contracargo recibido! Revisión manual requerida.')
            ->attachment(function ($attachment) {
                $title = 'Notificación IPN #' . $this->ipn_id;

                $attachment->title($title, env('MERCADO_PAGO_PANEL_URL'))
                    ->fields([
                        'IPN ID' => $this->ipn_id,
                        'IPN topic' => $this->ipn_topic,
                    ]);
            });
    }
}
