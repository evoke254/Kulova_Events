<?php

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


Route::match(['post', 'get'],'/voting/ussd', [\App\Http\Controllers\ElectionController::class, 'ussd'])->name('api.voting.ussd');
//Route::match(['post', 'get'],'/voting/whatsapp', [\App\Http\Controllers\ElectionController::class, 'whatsapp'])->name('api.voting.ussd');
Route::match(['post', 'get'],'/voting/whatsapp', [\App\Http\Controllers\ElectionController::class, 'setWatsappWebhook']);

Route::match(['post', 'get'],'/voting/setWatsappWebhook',[\App\Http\Controllers\ElectionController::class, 'whatsapp'])->name('api.voting.ussd');
Route::match(['post', 'get'],'/voting/test', [\App\Http\Controllers\ElectionController::class, 'test']);
Route::match(['post', 'get'],'/MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1O', [\App\Http\Controllers\OrderController::class, 'stkPushCallback']);
