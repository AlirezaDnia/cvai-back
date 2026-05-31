<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResumeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated via Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('resumes')->group(function () {
        Route::post('/', [ResumeController::class, 'store']);
        // Route::put('/{resume}', [ResumeController::class, 'update']);
    });

    Route::post('/resumes/{resume}/optimize', [AIController::class, 'optimize']);
});
