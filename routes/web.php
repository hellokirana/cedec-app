<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Data\BankController;
use App\Http\Controllers\Data\AdminController;
use App\Http\Controllers\Data\OrderController;
use App\Http\Controllers\Data\SliderController;
use App\Http\Controllers\Data\WorkerController;
use App\Http\Controllers\Data\LayananController;
use App\Http\Controllers\Data\StudentController;
use App\Http\Controllers\Data\KategoriController;
use App\Http\Controllers\Data\WithdrawController;
use App\Http\Controllers\Data\WorkshopController;
use App\Http\Controllers\Data\TestimoniController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Data\WorkshopRegistrationController;

// Route untuk autentikasi (login, register, forgot password)
Auth::routes(['verify' => true]);

// Halaman yang hanya bisa diakses oleh user login & verified
Route::middleware(['auth', 'verified'])->group(function () {
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
        Route::resource('/data/bank', BankController::class);
        Route::resource('/data/student', StudentController::class);
        Route::resource('/data/admin', AdminController::class);
        Route::resource('/data/workshop', WorkshopController::class);

        Route::group(['prefix' => 'data', 'middleware' => 'auth'], function () {
            // Workshop routes yang sudah ada
            Route::resource('registration', WorkshopRegistrationController::class);

            // Workshop registration routes (tambahan baru)
            Route::get('workshop-registration/{workshop}/', [WorkshopRegistrationController::class, 'showRegistrations'])
                ->name('registrations');

            Route::get('workshop/{workshop}/registrations/{registration}/edit', [WorkshopRegistrationController::class, 'editRegistration'])
                ->name('workshop.registration.edit');

            Route::put('workshop/{workshop}/registrations/{registration}', [WorkshopRegistrationController::class, 'updateRegistration'])
                ->name('workshop.registration.update');

            Route::delete('workshop/{workshop}/registrations/{registration}', [WorkshopRegistrationController::class, 'destroyRegistration'])
                ->name('workshop.registration.destroy');

            Route::get('workshop-registration/{id}/confirm', [WorkshopRegistrationController::class, 'confirm']);
            Route::get('workshop-registration/{id}/reject', [WorkshopRegistrationController::class, 'reject']);
        });

        // Payment Confirmation Routes - DIPINDAHKAN KE DALAM GRUP SUPERADMIN
        Route::get('/payment/confirmation', [WorkshopRegistrationController::class, 'paymentConfirmation'])
            ->name('payment.confirmation');

        Route::get('data/workshop-registration/{id}/confirm', [WorkshopRegistrationController::class, 'confirm']);
        Route::get('data/workshop-registration/{id}/reject', [WorkshopRegistrationController::class, 'reject']);

    });

});

// Email Verification View
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});