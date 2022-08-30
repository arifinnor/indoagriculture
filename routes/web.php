<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Controllers\WelcomePageController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('attributes', \App\Http\Controllers\AttributeController::class);
});

Route::get('/products/{product}/summary/{locale?}', \App\Http\Controllers\ProductSummaryController::class)->name('summary');
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'change'])->name('lang');



require __DIR__ . '/auth.php';
