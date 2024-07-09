<?php

use App\Http\Controllers\PostController;
use App\RMVC\Route\Route;


Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('posts/{post}', [PostController::class, 'show']);