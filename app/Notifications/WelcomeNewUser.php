<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class WelcomeNewUser extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        //return (new MailMessage)
                    //->subject('¡Bienvenido a nuestra plataforma!')
                    //->greeting('Hola, ' . $this->user->name)
                    //->line('¡Gracias por registrarte en nuestra plataforma!')
                    //->line('Esperamos que disfrutes de nuestros servicios.')
                    //->action('Comienza a explorar', url('/ingresar'))
                    //->line('¡Gracias por unirte a nosotros!');

                    $imageUrl = asset('img/mail-notification/welcome_image.jpg');
                    $loginUrl = url('/suscripcion/comprar/new-user');
                    
                    return (new MailMessage)
                    ->subject('¡Bienvenido a nuestra plataforma!')
                    ->greeting('Hola, ' . $this->user->name)
                    ->line('¡Gracias por registrarte en nuestra plataforma!')
                    ->line('Esperamos que disfrutes de nuestros servicios.')
                    ->line(new HtmlString('<a href="' . $loginUrl . '"><img src="' . $imageUrl . '" alt="Imagen de bienvenida"></a>'))
                    //->action('Comienza a explorar', url('/ingresar'))
                    ->action('Conoce nuestras plataformas', url('https://banquea.pe'))
                    
                    //->attach(public_path('img/mail-notification/welcome_image.jpg'), [
                        //'as' => 'welcome_image.jpg',
                    //])
                    ;
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
