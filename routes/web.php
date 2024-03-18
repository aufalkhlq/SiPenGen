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
        Route::post('/user', 'store')->name('user.store');
        Route::get('/user/{user}', 'show')->name('user.show');
        Route::get('/user/{user}/edit', 'edit')->name('user.edit');
        Route::put('/user/{user}', 'update')->name('user.update');
        Route::delete('/user/{user}', 'delete')->name('user.delete');
    });
    // dosen
    Route::controller('App\Http\Controllers\DosenController')->group(function(){
        Route::get('/dosen', 'index')->name('dosen');
        Route::post('/dosen', 'store')->name('dosen.store');
        Route::get('/dosen/{dosen}', 'show')->name('dosen.show');
        Route::get('/dosen/{dosen}/edit', 'edit')->name('dosen.edit');
        Route::put('/dosen/{dosen}', 'update')->name('dosen.update');
        Route::delete('/dosen/{dosen}', 'delete')->name('dosen.delete');
    });
    // kelas
    Route::controller('App\Http\Controllers\KelasController')->group(function(){
        Route::get('/kelas', 'index')->name('kelas');
        Route::post('/kelas', 'store')->name('kelas.store');
        Route::get('/kelas/{kelas}', 'show')->name('kelas.show');
        Route::get('/kelas/{kelas}/edit', 'edit')->name('kelas.edit');
        Route::put('/kelas/{kelas}', 'update')->name('kelas.update');
        Route::delete('/kelas/{kelas}', 'delete')->name('kelas.delete');
    });
});



Route::get('/users', function (){
    return view ('welcome');
})->name('welcome');
