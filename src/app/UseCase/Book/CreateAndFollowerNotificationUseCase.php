<?php

namespace App\UseCase\Book;

use App\Models\Book;
use App\Notifications\Book\ReleaseNotification;
use App\Services\BookService;
use App\Services\FollowUserService;
use Notification;

class CreateAndFollowerNotificationUseCase
{
    public function __construct(
        protected BookService $book_service,
        protected FollowUserService $follow_user_service
    ) {
    }

    public function __invoke(int $user_id, array $attributes): Book
    {
        /** @var Book $book */
        $book = $this->book_service->create($attributes);
        $follow_users = $this->follow_user_service->getFollowerUsers($user_id)->pluck('followerUser');
        Notification::send($follow_users, new ReleaseNotification($book));

        return $book;
    }
}
