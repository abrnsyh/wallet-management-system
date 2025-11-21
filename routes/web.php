<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Members
    Route::resource('members', MemberController::class)->except(['create', 'edit']);
    Route::get('/members/{member}/logs', [MemberController::class, 'logIndex'])
        ->name('members.logs');

    // Transactions
    Route::post('/members/{member}/topup', [TransactionController::class, 'topup'])
        ->name('members.topup');
    Route::post('/members/{member}/deduct', [TransactionController::class, 'deduct'])
        ->name('members.deduct');

});
