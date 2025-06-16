<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GaransiKlaimController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Dashboard berdasarkan Role
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/mitra/dashboard', function () {
        return view('mitra.dashboard');
    })->middleware('role:mitra')->name('mitra.dashboard');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->middleware('role:user')->name('user.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/klaim-garansi', [GaransiKlaimController::class, 'store']); // User mengajukan klaim
    Route::get('/klaim-garansi', [GaransiKlaimController::class, 'index']); // User melihat klaim
    Route::resource('users', UserController::class);
    Route::resource('jasas', JasaController::class);
    Route::resource('layanans', LayananController::class);
    Route::resource('orders', OrderController::class);

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('/klaim-garansi/{id}', [GaransiKlaimController::class, 'update']); // Admin menyetujui / menolak klaim
    Route::get('/admin/mitra/create', [AdminController::class, 'createMitra'])->name('admin.createMitra');
    Route::post('/admin/mitra/store', [AdminController::class, 'storeMitra'])->name('admin.storeMitra');
});

Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/activate', [AuthenticatedSessionController::class, 'activateAccount'])->name('activate.account');
    Route::post('/activate', [AuthenticatedSessionController::class, 'activate'])->name('activate');
    Route::get('/mitra/dashboard', [MitraDashboardController::class, 'index'])->name('mitra.dashboard');

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

require __DIR__ . '/auth.php';
