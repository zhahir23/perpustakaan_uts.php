<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('categories', CategoryController::class)
        ->except(['show'])
        ->middleware('role:admin,petugas');

    Route::resource('books', BookController::class)
        ->except(['show'])
        ->middleware('role:admin,petugas');

    Route::resource('members', MemberController::class)
        ->except(['show'])
        ->middleware('role:admin,petugas');

    Route::get('/loans', [LoanController::class, 'index'])
        ->name('loans.index')
        ->middleware('role:admin,petugas');

    Route::get('/loans/create', [LoanController::class, 'create'])
        ->name('loans.create')
        ->middleware('role:admin,petugas');

    Route::post('/loans', [LoanController::class, 'store'])
        ->name('loans.store')
        ->middleware('role:admin,petugas');

    Route::put('/loans/{id}', [LoanController::class, 'update'])
        ->name('loans.update')
        ->middleware('role:admin,petugas');

    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('role:admin');
});
