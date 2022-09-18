<?php

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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



Route::group([
    'name' => 'v1.',
    'prefix' => 'v1',
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum')->name('auth.profile');

    // Owner Routes
    Route::group([
        'name' => 'owner.',
        'prefix' => 'owner',
        'middleware' => ['auth:sanctum', 'authenticatedOwner']
    ], function () {
    });

    // User Routes
    Route::group([
        'name' => 'user.',
        'prefix' => 'user',
        'middleware' => ['auth:sanctum', 'authenticatedUser']
    ], function () {
    });
});
