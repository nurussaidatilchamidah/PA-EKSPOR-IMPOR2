<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PrediksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboardpublic', function () {
    return view('dashboard-public');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {

// DATA BULANAN
    Route::get('/data', [AdminController::class, 'index'])->name('admin.data');
    Route::get('/data/create', [AdminController::class, 'create'])->name('admin.data.create');
    Route::post('/data/store', [AdminController::class, 'store'])->name('admin.data.store');
    Route::get('/data/edit/{id}', [AdminController::class, 'edit'])->name('admin.data.edit');
    Route::put('/data/update/{id}', [AdminController::class, 'update'])->name('admin.data.update');
    Route::delete('/data/delete/{id}', [AdminController::class, 'destroy'])->name('admin.data.delete');

    Route::post('/import-bulanan', [AdminController::class, 'importBulanan'])->name('import.bulanan');
    Route::post('/import-hs', [AdminController::class, 'importHS'])->name('import.hs');
 
    // DATA HS
    Route::get('/data-hs', [AdminController::class, 'dataHS'])->name('admin.data.hs');
    Route::get('/data-hs/create', [AdminController::class, 'createHS'])->name('admin.data.hs.create');
    Route::post('/data-hs/store', [AdminController::class, 'storeHS'])->name('admin.data.hs.store');
    Route::get('/data-hs/edit/{id}', [AdminController::class, 'editHS'])->name('admin.data.hs.edit');
    Route::put('/data-hs/update/{id}', [AdminController::class, 'updateHS'])->name('admin.data.hs.update');
    Route::delete('/data-hs/delete/{id}', [AdminController::class, 'destroyHS'])->name('admin.data.hs.delete');

});

});


// Prediksi Routes
Route::get('/admin/prediksi-arima',[PrediksiController::class,'arima'])->name('prediksi.arima');

// evaluasi model Routes
Route::get('/admin/evaluasi-model', [PrediksiController::class, 'evaluasi'])->name('evaluasi.model');

require __DIR__.'/auth.php';
