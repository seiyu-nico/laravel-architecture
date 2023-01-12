<?php

namespace App\Mails\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReleaseEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  User  $user
     */
    public function __construct(
        protected User $user,
        protected Book $book
    ) {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text(
            'mails.book.release',
            [
                'user' => $this->user,
                'book' => $this->book,
            ]
        )
            ->to($this->user->email)
            ->subject('フォローユーザが新しい本を公開しました');
    }
}
