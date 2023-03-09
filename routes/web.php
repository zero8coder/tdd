<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [ThreadsController::class, 'index']);
Route::get('/threads', [ThreadsController::class, 'index']);
Route::get('/threads/{thread}', [ThreadsController::class, 'show']);
Route::post('/threads/{thread}/replies', [RepliesController::class, 'store']);
