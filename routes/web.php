<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Route::get('/', [OrderController::class, 'index'])
    ->name('customer.index');

Route::middleware(['auth', 'role:customer'])
    ->group(function () {
        Route::post('/checkout', [
            OrderController::class,
            'store'
        ])->name('customer.checkout');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [
            OrderController::class,
            'adminDashboard'
        ])->name('dashboard');

        Route::patch('/orders/{id}/status', [
            OrderController::class,
            'updateStatus'
        ])->name('orders.updateStatus');

        Route::resource('/events', EventController::class);
    });

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');
});

require __DIR__.'/auth.php';