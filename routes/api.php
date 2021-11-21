<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserBalanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTransactionController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('userBalance', UserBalanceController::class);
    Route::resource('user', UserController::class);
    Route::post('userTransactionTransfer', [UserTransactionController::class, 'transactionTransfer']);
    Route::post('userTransactionTopUp', [UserTransactionController::class, 'transactionTopUp']);
    Route::resource('userTransaction', UserTransactionController::class);
    Route::post('logout', [LoginController::class, 'logout']);
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
