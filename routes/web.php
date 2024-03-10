<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" midd leware group. Make something great!
|
*/

// Auth
Route::controller('App\Http\Controllers\AuthController')->group(function(){
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/logout', 'logout')->name('logout');
});

// Dashboard
Route::group(['middleware' => 'auth'], function(){
    Route::controller('App\Http\Controllers\DashboardController')->group(function(){
        Route::get('/', 'index')->name('dashboard');
    });
    Route::controller('App\Http\Controllers\UserController')->group(function(){
        Route::get('/user', 'index')->name('user');
        // Route::post('/users/create', 'create')->name('user.create');
        Route::post('/user', 'store')->name('user.store');
        // Route::get('/users/{user}', 'show')->name('users.show');
        // Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        // Route::put('/users/{user}', 'update')->name('users.update');
        // Route::delete('/users/{user}', 'destroy')->name('users.destroy');
    });
});


// User


Route::get('/users', function (){
    return view ('welcome');
})->name('welcome');
