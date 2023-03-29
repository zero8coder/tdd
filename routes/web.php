<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [ThreadsController::class, 'index']);
Route::get('/threads/create', [ThreadsController::class, 'create']);
Route::get('/threads/{channel}/{thread}', [ThreadsController::class, 'show']);
Route::delete('/threads/{channel}/{thread}', [ThreadsController::class, 'destroy']);
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store']);
Route::get('/threads/{channel?}', [ThreadsController::class, 'index']);
Route::post('/threads', [ThreadsController::class, 'store']);
Route::patch('/replies/{reply}', [RepliesController::class, 'update']);
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy']);
Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store']);
Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
