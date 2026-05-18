<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/login', [HomeController::class, 'login']);

Route::get('/vehicles', function () {
    return view('vehicles.index');
})->name('vehicles.index');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/users', function () {
    return view('users.index');
})->name('users.index');

Route::get('/roles', function () {
    return view('roles.index');
})->name('roles.index');
Route::post('/logout', function () {
    return redirect('/login');
})->name('logout');