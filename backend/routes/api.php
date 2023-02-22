<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\Auth;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::group(['middleware' => 'App\Http\Middleware\Auths'], function () {
        Route::apiResource('role', RoleController::class);
    });
    Route::post('logout', [UserController::class, 'logout']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


// Route::get('/role', [RoleController::class, 'index']);
