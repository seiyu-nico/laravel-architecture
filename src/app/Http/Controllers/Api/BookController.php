<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCase\Book\ShowUserBooksUseCase;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * @param  int  $user_id
     * @param  ShowUserBooksUseCase  $use_case
     * @return JsonResponse
     */
    public function showUserBooks(
        int $user_id,
        ShowUserBooksUseCase $use_case
    ): JsonResponse {
        return response()->json($use_case($user_id), 200);
    }
}
