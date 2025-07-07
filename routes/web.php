<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Data\WorkerController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Data\BankController;
use App\Http\Controllers\Data\SliderController;
use App\Http\Controllers\Data\KategoriController;
use App\Http\Controllers\Data\TestimoniController;
use App\Http\Controllers\Data\LayananController;
use App\Http\Controllers\Data\StudentController;
use App\Http\Controllers\Data\AdminController;
use App\Http\Controllers\Data\OrderController;
use App\Http\Controllers\Data\WithdrawController;

// Route untuk autentikasi (login, register, forgot password)
Auth::routes(['verify' => true]);

// Halaman yang hanya bisa diakses oleh user login & verified
Route::middleware(['auth', 'verified'])->group(function () {
    // ✅ Halaman frontend yang dilindungi login
    Route::get('/', [FrontendController::class, 'index']);
    Route::get('/workshop', [FrontendController::class, 'workshop']);
    Route::get('/workshop/{id}', [FrontendController::class, 'workshop_detail']);
    Route::get('/my-workshop', [FrontendController::class, 'my_workshop']);
    Route::post('/send_workshop_registration', [FrontendController::class, 'send_workshop_registration'])->name('send_workshop_registration');
    Route::get('/result', action: [FrontendController::class, 'result']);
    Route::get('/contact', action: [FrontendController::class, 'contact']);

    // Profil & Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
    Route::post('/update_profil', [HomeController::class, 'update_profil'])->name('update_profil');

    // Pesan & Workshop
    Route::get('/pesan/{id}', [HomeController::class, 'pesan'])->name('pesan');

    // Admin-Only Routes (pakai role superadmin)
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('/data/slider', SliderController::class);
        Route::resource('/data/kategori', KategoriController::class);
        Route::resource('/data/bank', BankController::class);
        Route::resource('/data/testimoni', TestimoniController::class);
        Route::resource('/data/layanan', LayananController::class);
        Route::resource('/data/student', StudentController::class);
        Route::resource('/data/admin', AdminController::class);
    });

    // Worker data
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('/data/worker', WorkerController::class);
        Route::get('worker/create', [WorkerController::class, 'create'])->name('worker.create');
        Route::put('/data/worker/{id}', [WorkerController::class, 'update'])->name('worker.update');
        Route::get('workers/{id}', [WorkerController::class, 'show'])->name('worker.show');
    });

    // Order handling
    Route::resource('/data/order', OrderController::class);
    Route::get('/data/order/{id}/success_order', [OrderController::class, 'success_order']);
    Route::get('/data/order/{id}/konfirmasi', [OrderController::class, 'konfirmasi']);
    Route::post('/data/order/{id}/send_konfirmasi', [OrderController::class, 'send_konfirmasi']);
    Route::get('/data/order/{id}/bayar_diterima', [OrderController::class, 'bayar_diterima']);
    Route::get('/data/order/{id}/bayar_ditolak', [OrderController::class, 'bayar_ditolak']);
    Route::get('/data/order/{id}/terima_pekerjaan', [OrderController::class, 'terima_pekerjaan']);
    Route::get('/data/order/{id}/selesai_pekerjaan', [OrderController::class, 'selesai_pekerjaan']);
    Route::get('/data/order/{id}/upload-proof', [OrderController::class, 'uploadProof'])->name('order.upload_proof');
    Route::post('/data/order/{id}/upload-proof', [OrderController::class, 'uploadProof'])->name('order.upload_proof');
    Route::post('/data/order/{id}/submit-description', [OrderController::class, 'submitDescription'])->name('order.submit_description');

    // Withdraw (role: superadmin OR worker)
    Route::middleware('role:superadmin|worker')->group(function () {
        Route::get('/data/withdraw/{id}/diproses', [WithdrawController::class, 'diproses']);
        Route::get('/data/withdraw/{id}/selesai', [WithdrawController::class, 'selesai']);
        Route::get('/data/withdraw/{id}/ditolak', [WithdrawController::class, 'tolak']);
        Route::resource('/data/withdraw', WithdrawController::class);
    });

    // Wilayah (Ajax lokasi)
    Route::get('get-cities/{province_code}', [HomeController::class, 'getCities'])->name('get-cities');
    Route::get('get-districts/{city_code}', [HomeController::class, 'getDistricts'])->name('get-districts');
    Route::get('get-villages/{district_code}', [HomeController::class, 'getVillages'])->name('get-villages');
});

// Email Verification View
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
