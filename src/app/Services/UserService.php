<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\Core\Service;

/**
 * @property UserRepository $repository
 */
class UserService extends Service
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
