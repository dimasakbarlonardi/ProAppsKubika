<?php

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\UserController;
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

Route::prefix('v1')->group(function() {
    Route::get('/', function() {
        return ResponseFormatter::success('PRO APPS API V1');
    });
    Route::get('sites', [SiteController::class, 'sites']);
    Route::post('login', [UserController::class, 'login'])->name('api-login');

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/user', [UserController::class, 'user'])->name('user');

        Route::post('/select-role', [UserController::class, 'selectRole']);

    });
});

