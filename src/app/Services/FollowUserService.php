<?php

namespace App\Services;

use App\Repositories\FollowUserRepository;
use App\Services\Core\Service;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property FollowUserRepository $repository
 */
class FollowUserService extends Service
{
    public function __construct(FollowUserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getFollowerUsers(int $user_id): Collection
    {
        return $this->repository->findWithConditions(
            conditions: ['follow_user_id' => $user_id],
            relations: ['followerUser']
        );
    }
}
