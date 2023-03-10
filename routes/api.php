<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::apiResource('users', UserController::class);
    Route::apiResource('genres', GenreController::class);
    Route::apiResource('books', BookController::class);

    Route::get('loans', [BookLoanController::class, 'index'])->name('loans.index');
    Route::post('loans', [BookLoanController::class, 'store'])->name('loans.store');
    Route::patch('loans/set-returned/{id}', [BookLoanController::class, 'setBookReturn'])->name('loans.set-returned');
    Route::patch('loans/set-delayed/{id}', [BookLoanController::class, 'setLoanDelayed'])->name('loans.set-delayed');
});
