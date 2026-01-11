<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']) ->name('dashboard');
    Route::post('/transactions', [DashboardController::class, 'store']);
    Route::get('/dashboard/data', [DashboardController::class, 'data']);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('services', ServiceController::class);
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', [TransactionController::class, 'dashboard'])
    //     ->name('dashboard');

    Route::get('/transactions/create', [TransactionController::class, 'create'])
        ->name('transactions.create');

    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');

    Route::post('/transactions/{id}', [TransactionController::class, 'update'])
        ->name('transactions.update');

    Route::delete('/transactions/{id}', [TransactionController::class, 'delete'])
        ->name('transactions.delete');

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::get('/transactions/recent-items', [TransactionController::class,'recentTransactions'])
    ->name('transactions.recentTransactions');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reports/charts', [ReportController::class, 'charts'])
    ->name('reports.charts');
    Route::get('/reports/service-charts', [ReportController::class, 'serviceCharts'])
    ->name('reports.service.charts');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/contacts', ContactController::class);
});


require __DIR__.'/auth.php';
