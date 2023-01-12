<?php

namespace App\Notifications\Book;

use App\Mails\Book\ReleaseEmail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReleaseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param  Book  $book
     * @return void
     */
    public function __construct(
        protected Book $book
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  User  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  User  $notifiable
     * @return ReleaseEmail
     */
    public function toMail($notifiable)
    {
        return new ReleaseEmail($notifiable, $this->book);
    }
}
