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
Route::apiResource('/author', 'App\Http\Controllers\AuthorController');
Route::apiResource('/book', 'App\Http\Controllers\BookController');
Route::apiResource('/rating', 'App\Http\Controllers\RatingController');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
