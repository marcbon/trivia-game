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

// CRUD
// 1. [GET] /api/questions
// 2. [POST] /api/questions
// 3. [GET] /api/questions/{id}
// 4. [PUT] /api/questions/{id}
// 5. [DELETE] /api/questions/{id}

// Create resoruce (questions)
// 1. Create the database and migrations
// 2. Create a model
// 3. Create a service (Eloquent ORM)
// 4. Create a controller
// 5. Return the data

Route::get('/test', function() {
    return ['message' => 'okay'];
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
