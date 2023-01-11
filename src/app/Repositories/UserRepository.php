<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Core\EloquentRepository;

/**
 * @property User $model
 */
class UserRepository extends EloquentRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
