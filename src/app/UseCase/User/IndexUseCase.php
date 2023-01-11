<?php

namespace App\UseCase\User;

use App\Services\UserService;

class IndexUseCase
{
    public function __construct(
        protected UserService $service
    ) {
    }

    public function __invoke()
    {
        return $this->service->all();
    }
}
