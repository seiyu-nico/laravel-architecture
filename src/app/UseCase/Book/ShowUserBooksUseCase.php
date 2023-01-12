<?php

namespace App\UseCase\Book;

use App\Services\BookService;
use Illuminate\Support\Collection;

class ShowUserBooksUseCase
{
    public function __construct(
        protected BookService $service
    ) {
    }

    public function __invoke(int $user_id): Collection
    {
        return $this->service->findByUserId($user_id);
    }
}
