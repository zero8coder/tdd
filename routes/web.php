<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\ThreadSubscriptionsController;
use App\Http\Controllers\UserNotificationsController;
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

Route::get('/threads/{channel}/{thread}/replies',[RepliesController::class, 'index']);
Route::patch('/replies/{reply}', [RepliesController::class, 'update']);
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy']);

Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store']);
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy']);

Route::post('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'store']);
Route::delete('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'destroy']);

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
Route::get('/profiles/{user}/notifications',[UserNotificationsController::class, 'index']);
Route::delete('/profiles/{user}/notifications/{notification}', [UserNotificationsController::class, 'destroy']);

