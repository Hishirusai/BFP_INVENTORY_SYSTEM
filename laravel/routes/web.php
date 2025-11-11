<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\ItemTransferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Item management routes
    Route::resource('items', ItemController::class);
    Route::get('/items/{item}/json', [ItemController::class, 'showJson'])->name('items.show.json');
    Route::get('/items/export/csv', [ItemController::class, 'export'])->name('items.export');
    
    // Item transfer routes
    Route::get('/items/transfer/create', [ItemTransferController::class, 'create'])->name('items.transfer.create');
    Route::post('/items/transfer', [ItemTransferController::class, 'store'])->name('items.transfer.store');
    
    // Station routes
    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
    Route::get('/stations/create', [StationController::class, 'create'])->name('stations.create');
    Route::post('/stations', [StationController::class, 'store'])->name('stations.store');
    Route::get('/stations/{station}', [StationController::class, 'show'])->name('stations.show');
    Route::get('/stations/{station}/export', [StationController::class, 'export'])->name('stations.export');
    Route::delete('/stations/{station}', [StationController::class, 'destroy'])->name('stations.destroy');

    // Admin routes
    Route::get('/admin/suppliersettings', [AdminController::class, 'index'])->name('admin.settings');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/suppliers', [AdminController::class, 'storeSupplier'])->name('admin.suppliers.store');
    Route::put('/admin/suppliers/{supplier}', [AdminController::class, 'updateSupplier'])->name('admin.suppliers.update');
    Route::delete('/admin/suppliers/{supplier}', [AdminController::class, 'destroySupplier'])->name('admin.suppliers.destroy');

    // Admin user management routes
    Route::put('/admin/users/{user}/email', [AdminController::class, 'updateUserEmail'])->name('admin.users.update.email');
    Route::put('/admin/users/{user}/password', [AdminController::class, 'updateUserPassword'])->name('admin.users.update.password');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Reports routes
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportsController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [ReportsController::class, 'show'])->name('reports.show');
    Route::delete('/reports/{report}', [ReportsController::class, 'destroy'])->name('reports.destroy');
});



require __DIR__ . '/auth.php';
