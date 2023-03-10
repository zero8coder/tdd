<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [ThreadsController::class, 'index']);
Route::get('/threads/create', [ThreadsController::class, 'create']);
Route::get('/threads/{channel}/{thread}', [ThreadsController::class, 'show']);
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store']);
Route::get('/threads/{channel?}', [ThreadsController::class, 'index']);
Route::post('/threads', [ThreadsController::class, 'store']);
//Route::resource('threads','ThreadsController');
