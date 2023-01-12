<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCase\User\IndexUseCase;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(
        IndexUseCase $use_case
    ): JsonResponse {
        return response()->json($use_case(), 200);
    }
}
