<?php

use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;


Route::get('/threads', [ThreadsController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
