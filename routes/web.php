<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('analysis', [AnalysisController::class, 'index'])->name('analysis');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('items', ItemController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('purchases', PurchaseController::class);
});

Route::get('/inertia-test', function () {
    return Inertia::render('InertiaTest');
});

Route::get('inertia/index', [InertiaTestController::class, 'index'])->name('inertia.index');
Route::get('inertia/show/{id}', [InertiaTestController::class, 'show'])->name('inertia.show');
Route::post('inertia/store', [InertiaTestController::class, 'store'])->name('inertia.store');
Route::get('inertia/create', [InertiaTestController::class, 'create'])->name('inertia.create');
Route::delete('inertia/delete/{id}', [InertiaTestController::class, 'delete'])->name('inertia.delete');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';
