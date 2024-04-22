<?php

namespace App\Notifications;

use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Trello\TrelloChannel;
use NotificationChannels\Trello\TrelloMessage;

class QuestionReported extends Notification implements ShouldQueue
{
    use Queueable;

    protected $question;
    protected $user;
    protected $user_message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Question $question, User $user, $user_message)
    {
        $this->question = $question;
        $this->user = $user;
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
        return [
            'mail',
            TrelloChannel::class,
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
            ->subject('¡Gracias por reportar una pregunta!')
            ->cc(env('MAIL_FROM_ADDRESS'))
            ->markdown('mail.question.reported', [
                'question' => $this->question,
                'user' => $this->user,
                'user_message' => $this->user_message,
            ]);
    }

    /**
     * Get the Trello representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Trello\TrelloMessage
     */
    public function toTrello($notifiable)
    {
        $now = Carbon::now();
        $due = Carbon::now()->addWeek()->toDateString();
        $report_id = uniqid();

        // Report description.
        $description_report = "Reporte
---

- **Fecha:** " . $now . "
- **ID:** " . $report_id;

        // Message description.
        $description_message = "Mensaje
---

";
        if (!$this->user_message) {
            $description_message .= "_Reporte sin mensaje._";
        } else {
            $description_message .= "```
" . $this->user_message . "
```";
        }

        // User description.
        $description_user = "Usuario
---

- **Nombre:** " . $this->user->name . "
- **ID:** #" . $this->user->id . "
- **Correo electrónico:** " . $this->user->email . "
- **Premium:** ";
        if ($this->user->isSubscribed()) {
            $description_user .= "Sí";
        } else {
            $description_user .= "No";
        }

        // Question description.
        $description_question = "Pregunta
---

- **Pregunta:** " . $this->question->text . "
- **ID:** #" . $this->question->id . "
- **Respuestas:**";
        foreach ($this->question->answers as $answer) {
            $description_question .= "
  - " . $answer->text;
            if ($answer->correct) {
                $description_question .= " (Correcta)";
            }
        }

        // Final description.
        $description = $description_report . "

" .  $description_message . "

" .  $description_user . "

" .  $description_question;

        return TrelloMessage::create()
            ->name("Reporte de " . $this->user->name . " sobre pregunta #" . $this->question->id . " (ID: " . $report_id . ")")
            ->description($description)
            ->bottom()
            ->due($due);
    }
}
