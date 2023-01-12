<?php

use App\Http\Controllers\Api;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/users', [Api\UserController::class, 'index'])->name('users');
    Route::get('/users/{id}/books', [Api\BookController::class, 'showUserBooks'])->name('users.books');
    Route::post('/books', [Api\BookController::class, 'store'])->name('books');
});
