<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController; 
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('vacacion', VacacionController::class);
Route::resource('users', UserController::class)->only(['index', 'update']);
Route::post('reserva', [ReservaController::class, 'store'])->name('reserva.store');
Route::post('comentario', [ComentarioController::class, 'store'])->name('comentario.store');
