<?php

use App\Http\Controllers\ChampsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KritikController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute publik
Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/forms', function () {
    return view('pages.forms.index');
});

Route::get('/buttons', function () {
    return view('pages.ui-features.buttons.index');
});

Route::get('/dropdowns', function () {
    return view('pages.ui-features.dropdowns.index');
});

Route::get('/typography', function () {
    return view('pages.ui-features.typography.index');
});

Route::get('/chart', function () {
    return view('pages.chart.index');
});

Route::get('/table', function () {
    return view('pages.table.index');
});

Route::get('/icons', function () {
    return view('pages.icons.index');
});

Route::get('/erro404', function () {
    return view('pages.error-pages.404.index');
});

Route::get('/erro500', function () {
    return view('pages.error-pages.500.index');
});

// Rute dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute kritik
    Route::get('/kritik/create', [KritikController::class, 'create'])->name('pages.kritikdansaran.create');
    Route::post('/kritik/store', [KritikController::class, 'store'])->name('pages.kritikdansaran.store');

    // Rute champ
    Route::get('/champs/create', [ChampsController::class, 'create'])->name('pages.champs.create');
    Route::post('/champs/store', [ChampsController::class, 'store'])->name('pages.champs.store');

    // Rute untuk admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/kritik/admin', [KritikController::class, 'indexAdmin'])->name('pages.kritik.index.admin');
        Route::get('/champs', [ChampsController::class, 'indexAdminChamps'])->name('pages.champs.indexAdmin');
    });

    // Rute untuk user
    Route::middleware(['role:user'])->group(function () {
        Route::get('/kritik/user', [KritikController::class, 'indexUser'])->name('pages.kritik.index.user');
        Route::get('/champs/user', [ChampsController::class, 'indexUserChamps'])->name('pages.champs.indexUser');
    });
});

require __DIR__ . '/auth.php';
