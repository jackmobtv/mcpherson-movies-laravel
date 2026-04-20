<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function (){
    Route::get('/', 'Home')->name('Home');
    Route::get('/about', 'About')->name('About');
    Route::get('/terms', 'Terms')->name('Terms');

    Route::get('/pricing', 'Pricing_Get')->name('Pricing_Get');
    Route::post('/pricing', 'Pricing_Post')->name('Pricing_Post');
});

Route::controller(UserController::class)->group(function (){
    Route::get('/signup', 'SignUp_Get')->name('SignUp_Get');
    Route::post('/signup', 'SignUp_Post')->name('SignUp_Post');

    Route::get('/login', 'Login_Get')->name('Login_Get');
    Route::post('/login', 'Login_Post')->name('Login_Post');

    Route::get('/logout', 'Logout')->name('Logout');

    Route::get('/favorites', 'Favorites')->name('Favorites');
    Route::get('/view-profile/favorites', 'User_Favorites')->name('User_Favorites');

    Route::get('/users', 'Users')->name('Users');
    Route::get('/view-profile', 'View_Profile')->name('View_Profile');

    Route::get('/edit-profile', 'Edit_Profile_Get')->name('Edit_Profile_Get');
    Route::post('/edit-profile', 'Edit_Profile_Post')->name('Edit_Profile_Post');

    Route::post('/users', 'Deactivate_User_Post')->name('Deactivate_User_Post');
});

Route::controller(MovieController::class)->group(function (){
    Route::get('/movies', 'Movies')->name('Movies');
    Route::get('/view-movie', 'View_Movie')->name('View_Movie');

    Route::get('/add-movie', 'Add_Movie_Get')->name('Add_Movie_Get');
    Route::post('/add-movie', 'Add_Movie_Post')->name('Add_Movie_Post');

    Route::get('/update-movie', 'Update_Movie_Get')->name('Update_Movie_Get');
    Route::post('/update-movie', 'Update_Movie_Post')->name('Update_Movie_Post');

    Route::post('/delete-movie', 'Delete_Movie_Post')->name('Delete_Movie_Post');
});

Route::controller(ActorController::class)->group(function (){
    Route::get('/actors', 'Actors')->name('Actors');
    Route::get('/view-actor', 'View_Actor')->name('View_Actor');

    Route::post('/add-actor', 'Add_Actor_Post')->name('Add_Actor_Post');

    Route::post('/update-actor', 'Update_Actor_Post')->name('Update_Actor_Post');

    Route::post('/delete-movie-actor', 'Remove_Movie_Actor_Post')->name('Remove_Movie_Actor_Post');
    Route::post('/delete-actor', 'Remove_Actor_Post')->name('Remove_Actor_Post');
});

