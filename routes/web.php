<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function (){
    Route::get('/', 'Home')->name('Home');
});

Route::controller(UserController::class)->group(function (){
    Route::get('/signup', 'SignUp_Get')->name('SignUp');
    Route::post('/signup', 'SignUp_Post')->name('SignUp_Post');

    Route::get('/login', 'Login_Get')->name('Login');
    Route::post('/login', 'Login_Post')->name('Login_Post');

    Route::get('/logout', 'Logout')->name('Logout');
});

Route::controller(MovieController::class)->group(function (){
    Route::get('/movies', 'Movies')->name('Movies');
});
