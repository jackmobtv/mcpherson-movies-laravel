<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function (){
    Route::get('/', 'Home')->name('Home');
});

Route::controller(UserController::class)->group(function (){
    Route::get('/signup', 'SignUp')->name('SignUp');
});
