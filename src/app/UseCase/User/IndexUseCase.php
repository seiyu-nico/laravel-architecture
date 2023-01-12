<?php

namespace App\UseCase\User;

use App\Services\UserService;
use Illuminate\Support\Collection;

class IndexUseCase
{
    public function __construct(
        protected UserService $service
    ) {
    }

    public function __invoke(): Collection
    {
        return $this->service->all();
    }
}
