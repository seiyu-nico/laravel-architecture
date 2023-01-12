<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Core\EloquentRepository;

/**
 * @property Book $model
 */
class BookRepository extends EloquentRepository
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }
}
