<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCase\User\IndexUseCase;

class UserController extends Controller
{
    public function index(
        IndexUseCase $use_case
    ) {
        return response()->json($use_case(), 200);
    }
}
