<?php

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
    // CRUD
    // 1. [GET] /api/questions
    // 2. [POST] /api/questions
    // 3. [GET] /api/questions/{id}
    // 4. [PUT] /api/questions/{id}
    // 5. [DELETE] /api/questions/{id}
    Route::apiResource('questions', 'QuestionController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
