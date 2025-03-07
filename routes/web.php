<?php

use App\Http\Controllers\ChampsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\ScheduleController;
use App\Models\Schedule;
use App\Http\Controllers\ScheduleDetailController;
use App\Http\Controllers\GameController;
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
Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.index');

// Rute profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route to show the schedule details and registration form
    Route::get('/schedule/{id_schedule}/details', [ScheduleDetailController::class, 'index'])->name('pages.schedule.daftarschedule.indexUser');

    // Route to handle registration submission
    Route::post('/schedule/register', [ScheduleDetailController::class, 'store'])->name('schedule_detail.store');

    // Rute kritik
    Route::get('/kritik/create', [KritikController::class, 'create'])->name('pages.kritikdansaran.create');
    Route::post('/kritik/store', [KritikController::class, 'store'])->name('pages.kritikdansaran.store');

    // Rute champ
    Route::get('/champs/create', [ChampsController::class, 'create'])->name('pages.champs.create');
    Route::post('/champs/store', [ChampsController::class, 'store'])->name('pages.champs.store');

    Route::get('/game/best-customer', [GameController::class, 'bestCustomerAHP'])->name('pages.game.bestCustomer');
    Route::get('/game/winners', [GameController::class, 'winners'])->name('pages.game.listCustomer');

    Route::get('/winners', [GameController::class, 'list'])->name('winners.list');

    // Rute schedule
    Route::get('create', [ScheduleController::class, 'create'])->name('pages.schedule.create');
    Route::post('store', [ScheduleController::class, 'store'])->name('pages.schedule.store');
    Route::get('{schedule}/edit', [ScheduleController::class, 'edit'])->name('pages.schedule.edit');
    Route::put('{schedule}', [ScheduleController::class, 'update'])->name('pages.schedule.update');
    Route::delete('{schedule}', [ScheduleController::class, 'destroy'])->name('pages.schedule.destroy');

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/champs', [ChampsController::class, 'indexAdminChamps'])->name('pages.champs.indexAdmin');
        Route::get('/schedule/admin', [ScheduleController::class, 'indexAdmin'])->name('pages.schedule.indexAdmin');
        Route::get('/kritik/admin', [KritikController::class, 'indexAdmin'])->name('pages.kritik.indexAdmin');
    });

    // User Routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/champs/user', [ChampsController::class, 'indexUserChamps'])->name('pages.champs.indexUser');
        Route::get('/schedule/user', [ScheduleController::class, 'indexUser'])->name('pages.schedule.indexUser');
        Route::get('/kritik/user', [KritikController::class, 'indexUser'])->name('pages.kritik.indexUser');
        Route::get('/games/user', [GameController::class, 'indexUser'])->name('games.indexUser');
    });
    Route::get('/games/user', [GameController::class, 'indexUser'])->name('games.indexUser');
    Route::resource('games', GameController::class);
});

require __DIR__ . '/auth.php';
