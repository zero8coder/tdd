<?php

use App\Http\Controllers\Api\UserAvatarController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Auth\RegisterConfirmationController;
use App\Http\Controllers\BestRepliesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\LockedThreadsController;
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
Route::patch('threads/{channel}/{thread}',[ThreadsController::class, 'update']);
Route::delete('/threads/{channel}/{thread}', [ThreadsController::class, 'destroy']);
Route::post('/threads/{channel}/{thread}/replies', [RepliesController::class, 'store']);
Route::get('/threads/{channel?}', [ThreadsController::class, 'index'])->name('threads');
Route::post('/threads', [ThreadsController::class, 'store'])->middleware('must-be-confirmed');
Route::post('locked-threads/{thread}',[LockedThreadsController::class, 'store'])
    ->name('locked-threads.store')
    ->middleware('admin');
Route::delete('locked-threads/{thread}',[LockedThreadsController::class, 'destroy'])
    ->name('locked-threads.destroy')
    ->middleware('admin');


Route::get('/threads/{channel}/{thread}/replies',[RepliesController::class, 'index']);
Route::post('/replies/{reply}/best', [BestRepliesController::class, 'store'])->name('best-replies.store');
Route::patch('/replies/{reply}', [RepliesController::class, 'update']);
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])->name('replies.destroy');

Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store']);
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy']);

Route::post('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'store']);
Route::delete('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'destroy']);

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
Route::get('/profiles/{user}/notifications',[UserNotificationsController::class, 'index']);
Route::delete('/profiles/{user}/notifications/{notification}', [UserNotificationsController::class, 'destroy']);
Route::get('/register/confirm',[RegisterConfirmationController::class, 'index'])
    ->name('register.confirm');

Route::get('api/users', [UsersController::class, 'index']);
Route::post('api/users/{user}/avatar', [UserAvatarController::class, 'store'])->middleware('auth')
    ->name('avatar');

