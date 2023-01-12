<?php

namespace App\Repositories;

use App\Models\FollowUser;
use App\Repositories\Core\EloquentRepository;

/**
 * @property FollowUser $model
 */
class FollowUserRepository extends EloquentRepository
{
    public function __construct(FollowUser $model)
    {
        parent::__construct($model);
    }
}
