<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\CreateRequest;
use App\UseCase\Book\CreateAndFollowerNotificationUseCase;
use App\UseCase\Book\ShowUserBooksUseCase;
use  Illuminate\Http\JsonResponse;

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

    public function store(
        CreateRequest $request,
        CreateAndFollowerNotificationUseCase $use_case
    ): JsonResponse {
        /*
            MEMO:
            本来であれば$request->validated()['user_id']ではなくAuth::ID()などだが
            ここではサンプルなのでRequestから取得する
         */
        return response()->json($use_case((int) $request->validated()['user_id'], (array) $request->validated()), 200);
    }
}
