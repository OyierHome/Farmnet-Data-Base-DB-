<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->with('organization')->first();
})->middleware('auth:sanctum');
Route::middleware('guest')->group(function () {
    Route::post('/user/create', [UserController::class, 'store_user']);
    Route::post('/user/login', [UserController::class, 'login']);
    Route::post('/user/verify', [UserController::class, 'verifyUser']);
});
