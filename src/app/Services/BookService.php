<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\BookRepository;
use App\Services\Core\Service;
use Illuminate\Support\Collection;

/**
 * @property BookRepository $repository
 */
class BookService extends Service
{
    public function __construct(BookRepository $repository)
    {
        parent::__construct($repository);
    }

    public function findByUserId(int $user_id): Collection
    {
        $books = $this->repository->findWithConditions(
            conditions: ['user_id' => $user_id],
            relations: ['reviews']
        );

        return $books->map(function (Book $book) {
            return [
                ...$book->only(
                    [
                        'id',
                        'user_id',
                        'title',
                        'content',
                    ]
                ),
                'avg_score' => $book->getAvgScore(),
            ];
        });
    }
}
