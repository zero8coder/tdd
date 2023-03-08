<?php

use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;


Route::get('/threads', [ThreadsController::class, 'index']);
Route::get('/threads/{thread}', [ThreadsController::class, 'show']);
Auth::routes();

