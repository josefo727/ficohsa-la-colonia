<?php

use App\Http\Controllers\Api\OrderCancellationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TransactionResultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('order-info', OrderController::class)->middleware('setconfigs')->name('api.order-info');
Route::post('order-cancellation', OrderCancellationController::class)->name('api.order-cancellation');
Route::post('transaction-result/{order_id}', TransactionResultController::class)->name('api.transaction-result');
