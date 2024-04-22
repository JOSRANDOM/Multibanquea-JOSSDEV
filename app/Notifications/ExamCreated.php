<?php

namespace App\Notifications;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $exam;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
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
        $user = $this->exam->user;

        $is_first_exam = false;
        $subject = '¡Has creado un nuevo examen!';

        if ($user->exams->count() === 1) {
            $is_first_exam = true;
            $subject = '¡Has creado tu primer examen!';
        }


        return (new MailMessage)
            ->subject($subject)
            ->markdown('mail.user.created-exam', [
                'exam' => $this->exam,
                'is_first_exam' => $is_first_exam,
                'subject' => $subject,
                'user' => $user,
            ]);
    }
}
