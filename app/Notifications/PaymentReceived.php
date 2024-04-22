<?php

namespace App\Notifications;

use App\Models\CheckoutReference;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $checkout_reference;
    protected $subscription;
    protected $ipn_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CheckoutReference $checkout_reference, Subscription $subscription = null, string $ipn_id)
    {
        $this->checkout_reference = $checkout_reference;
        $this->subscription = $subscription;
        $this->ipn_id = $ipn_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
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
            ->subject('Tu pago en ' . config('app.name'))
            ->bcc(env('MAIL_ADDRESS_NOTIFICATIONS'))
            ->markdown('mail.payment.received', [
                'checkout_reference' => $this->checkout_reference,
                'subscription' => $this->subscription,
                'user' => $this->checkout_reference->user,
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
        $total_price = 'S/ ' . strval(number_format($this->checkout_reference->total_price / 100, 2, ',', '.'));
        $amount_paid = 'S/ ' . strval(number_format($this->checkout_reference->amount_paid / 100, 2, ',', '.'));

        return (new SlackMessage)
            ->from(config('app.name'), ':moneybag:')
            ->to(env('SLACK_CHANNEL_PAYMENTS'))
            ->content('Nuevo pago en ' . config('app.name') . ': ' . $amount_paid)
            ->attachment(function ($attachment) use ($amount_paid, $total_price) {
                $amount_paid_message = $amount_paid . ' de ' . $total_price;

                if (!$this->subscription) {
                    $subscription_message = 'No activada';
                } else {
                    $subscription_message = 'Activada del ' . $this->subscription->starts_at . ' al ' . $this->subscription->ends_at;
                }

                $attachment->title('Pago #' . $this->ipn_id, env('MERCADO_PAGO_PANEL_URL'))
                    ->fields([
                        'Referencia de compra' => $this->checkout_reference->id . ' (' . config('app.name') . ')',
                        'Usuario' => $this->checkout_reference->user->name . ' (' . $this->checkout_reference->user->email . ')',
                        'Plan' => $this->checkout_reference->plan->name . ' (' . $this->checkout_reference->plan->slug . ')',
                        'Cupón' => $this->checkout_reference->plan->promo_code,
                        'Monto pagado' => $amount_paid_message,
                        'Suscripción' => $subscription_message,
                    ]);
            });
    }
}
