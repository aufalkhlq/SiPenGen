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

Route::get('/welcome', function () {
    return view('welcome');
});
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

    // ruangan
    Route::controller('App\Http\Controllers\RuanganController')->group(function(){
        Route::get('/ruangan', 'index')->name('ruangan');
        Route::post('/ruangan', 'store')->name('ruangan.store');
        Route::get('/ruangan/{ruangan}', 'show')->name('ruangan.show');
        Route::get('/ruangan/{ruangan}/edit', 'edit')->name('ruangan.edit');
        Route::put('/ruangan/{ruangan}', 'update')->name('ruangan.update');
        Route::delete('/ruangan/{ruangan}', 'delete')->name('ruangan.delete');
    });

    // matkul
    Route::controller('App\Http\Controllers\MatkulController')->group(function(){
        Route::get('/matkul', 'index')->name('matkul');
        Route::post('/matkul', 'store')->name('matkul.store');
        Route::get('/matkul/{matkul}', 'show')->name('matkul.show');
        Route::get('/matkul/{matkul}/edit', 'edit')->name('matkul.edit');
        Route::put('/matkul/{matkul}', 'update')->name('matkul.update');
        Route::delete('/matkul/{matkul}', 'delete')->name('matkul.delete');
    });

    //jam
    Route::controller('App\Http\Controllers\JamController')->group(function(){
        Route::get('/jam', 'index')->name('jam');
        Route::post('/jam', 'store')->name('jam.store');
        Route::get('/jam/{jam}', 'show')->name('jam.show');
        Route::get('/jam/{jam}/edit', 'edit')->name('jam.edit');
        Route::put('/jam/{jam}', 'update')->name('jam.update');
        Route::delete('/jam/{jam}', 'delete')->name('jam.delete');
    });

    //hari
    Route::controller('App\Http\Controllers\HariController')->group(function(){
        Route::get('/hari', 'index')->name('hari');
        Route::post('/hari', 'store')->name('hari.store');
        Route::get('/hari/{hari}', 'show')->name('hari.show');
        Route::get('/hari/{hari}/edit', 'edit')->name('hari.edit');
        Route::put('/hari/{hari}', 'update')->name('hari.update');
        Route::delete('/hari/{hari}', 'delete')->name('hari.delete');
    });

    // jadwal
    Route::controller('App\Http\Controllers\JadwalController')->group(function(){
        Route::get('/jadwal', 'index')->name('jadwal');
        Route::post('/jadwal', 'store')->name('jadwal.store');
        Route::post('/generate', 'generateSchedule')->name('jadwal.generate');
        Route::get('/jadwal/{jadwal}', 'show')->name('jadwal.show');
        Route::get('/jadwal/{jadwal}/edit', 'edit')->name('jadwal.edit');
        Route::put('/jadwal/{jadwal}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{jadwal}', 'delete')->name('jadwal.delete');
        Route::get('/jadwal/status', 'status')->name('jadwal.status');
    });

    // genetik
    // Route::controller('App\Http\Controllers\Genetik\GenetikController')->group(function(){
    //     Route::get('/genetik', 'index')->name('genetik');
    //     Route::post('/genetik', 'generateSchedule')->name('genetik.generate');
    //     Route::get('/genetik/{genetik}', 'show')->name('genetik.show');
    //     Route::get('/genetik/{genetik}/edit', 'edit')->name('genetik.edit');
    //     Route::put('/genetik/{genetik}', 'update')->name('genetik.update');
    //     Route::delete('/genetik/{genetik}', 'delete')->name('genetik.delete');
    // });

    // pengampu
    Route::controller('App\Http\Controllers\PengampuController')->group(function(){
        Route::get('/pengampu', 'index')->name('pengampu');
        Route::post('/pengampu', 'store')->name('pengampu.store');
        Route::get('/pengampu/{pengampu}', 'show')->name('pengampu.show');
        Route::get('/pengampu/{pengampu}/edit', 'edit')->name('pengampu.edit');
        Route::put('/pengampu/{pengampu}', 'update')->name('pengampu.update');
        Route::delete('/pengampu/{pengampu}', 'delete')->name('pengampu.delete');
    });

    //
    Route::controller('App\Http\Controllers\HomeController')->group(function(){
        route::get('/home', 'index')->name('home');
    });




    //
    Route::controller('App\Http\Controllers\HomeController')->group(function(){
        route::get('/home', 'index')->name('home');
    });




});



Route::get('/users', function (){
    return view ('welcome');
})->name('welcome');
