<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [ThreadsController::class, 'index']);
Route::resource('threads','ThreadsController');
Route::post('/threads/{thread}/replies', [RepliesController::class, 'store']);
