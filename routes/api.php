<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('post/{id}', [BlogApiController::class, 'get_blog']);
Route::get('posts', [BlogApiController::class, 'read']);
Route::post('posts/create', [BlogApiController::class, 'create_blog']);
Route::post('posts/update/{id}', [BlogApiController::class, 'update_blog']);
Route::delete('posts/delete/{id}', [BlogApiController::class, 'delete_blog']);
Route::get('posts/filter', [BlogApiController::class, 'filter_blog']);
