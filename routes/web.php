<?php

use App\Http\Controllers\DonorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Donor
Route::prefix('donor')->group(function () {
    Route::get('/dashboard', [DonorController::class, 'index'])->name('donor.dashboard');
    Route::get('/food/create', [DonorController::class, 'create'])->name('donor.food.create');
    Route::post('/food', [DonorController::class, 'store'])->name('donor.food.store');
    Route::get('/food/{foodItem}/edit', [DonorController::class, 'edit'])->name('donor.food.edit');
    Route::put('/food/{foodItem}', [DonorController::class, 'update'])->name('donor.food.update');
    Route::delete('/food/{foodItem}', [DonorController::class, 'destroy'])->name('donor.food.destroy');
    Route::get('/requests', [DonorController::class, 'requests'])->name('donor.requests.index');
    Route::patch('/requests/{claim}/approve', [DonorController::class, 'approve'])->name('donor.requests.approve');
    Route::patch('/requests/{claim}/reject', [DonorController::class, 'reject'])->name('donor.requests.reject');
});