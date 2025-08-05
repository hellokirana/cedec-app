<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Data\BankController;
use App\Http\Controllers\Data\AdminController;
use App\Http\Controllers\Data\ScoreController;
use App\Http\Controllers\Data\ProgramController;
use App\Http\Controllers\Data\StudentController;
use App\Http\Controllers\Data\WorkshopController;
use App\Http\Controllers\Data\CertificateController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Data\WorkshopRegistrationController;
use Illuminate\Support\Facades\Artisan;

// Route untuk autentikasi (login, register, forgot password)
Auth::routes(['verify' => true]);

// Halaman publik yang bisa diakses tanpa login
Route::get('/', [FrontendController::class, 'index']);
Route::get('/workshop', [FrontendController::class, 'workshop']);
Route::get('/workshop/{id}', [FrontendController::class, 'workshop_detail']);
Route::get('/contact', [FrontendController::class, 'contact']);

// Halaman yang hanya bisa diakses oleh user login & verified
Route::middleware(['auth', 'verified'])->group(function () {
    // Halaman yang memerlukan login dan verifikasi
    Route::get('/my-workshop', [FrontendController::class, 'my_workshop']);
    Route::post('/send_workshop_registration', [FrontendController::class, 'send_workshop_registration'])->name('send_workshop_registration');
    Route::get('/result', [FrontendController::class, 'result']);
    Route::get('/profile', [FrontendController::class, 'showStudentProfile'])->name('student.profile');
    Route::post('/profile/update-avatar', [FrontendController::class, 'updateAvatar'])->name('student.profile.avatar.update');
    Route::get('/my-certificate/{registration_id}/download', [FrontendController::class, 'downloadCertificate'])
        ->name('download.certificate');

    // Admin-Only Routes (pakai role superadmin)
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
        Route::get('/data/score', [ScoreController::class, 'index'])->name('score.index');
        Route::get('/data/score/upload', [ScoreController::class, 'upload'])->name('score.upload');
        Route::get('/data/certificate', [CertificateController::class, 'index'])->name('certificate.index');
        Route::post('/data/certificate/upload/{registration}', [CertificateController::class, 'upload'])->name('certificate.upload');
        Route::post('/update_profil', [HomeController::class, 'update_profil'])->name('update_profil');
        Route::get('data/certificate/{registration}/edit', [CertificateController::class, 'edit'])->name('certificate.edit');
        Route::post('data/certificate/{registration}/update', [CertificateController::class, 'update'])->name('certificate.update');

        Route::resource('/data/bank', BankController::class);
        Route::resource('/data/student', StudentController::class);
        Route::resource('/data/admin', AdminController::class);
        Route::resource('/data/workshop', WorkshopController::class);
        Route::resource('/data/program', ProgramController::class);

        Route::group(['prefix' => 'data', 'middleware' => 'auth'], function () {
            // Workshop routes yang sudah ada
            Route::resource('registration', WorkshopRegistrationController::class);

            Route::get('/score/upload', [ScoreController::class, 'showUploadForm'])->name('score.upload');
            Route::post('/score/import', [ScoreController::class, 'importScores'])->name('score.import');

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