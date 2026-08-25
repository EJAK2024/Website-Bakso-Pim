<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\TwoFactorController;

Route::get('/', [HomeController::class, 'index']);
Route::post('/kontak', [MessageController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('kontak.submit');
Route::get('/pesan', [HomeController::class, 'pesan'])->name('pesan');
Route::post('/pesan', [HomeController::class, 'submitOrder'])
    ->middleware('throttle:order')
    ->name('order.submit');
Route::get('/pesan/{order}/qris', [HomeController::class, 'qris'])
    ->middleware('signed')
    ->name('order.qris');
Route::get('/pesan/{order}/struk', [HomeController::class, 'struk'])
    ->middleware('signed')
    ->name('order.struk');
Route::put('/pesan/{order}/upload-proof', [HomeController::class, 'uploadProof'])
    ->middleware('signed', 'throttle:upload-proof')
    ->name('order.uploadProof');

Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login'])
    ->middleware('throttle:login');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::get('/admin/2fa/setup', [TwoFactorController::class, 'showSetupForm'])->name('2fa.setup');
    Route::post('/admin/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::get('/admin/2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
    Route::post('/admin/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');
    Route::post('/admin/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');
    Route::post('/admin/2fa/regenerate', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('2fa.regenerate');
});

Route::middleware(['admin', '2fa'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->middleware('activity');
    Route::get('/register', [AdminController::class, 'registerForm']);
    Route::post('/register', [AdminController::class, 'register'])
        ->middleware('throttle:register');

    Route::get('/admin/qrcode', [AdminController::class, 'qrcode'])->name('admin.qrcode');
    Route::get('/admin/payment-proofs', [OrderController::class, 'paymentProofs'])->name('orders.paymentProofs');

    Route::prefix('admin/menu')->name('menu.')->middleware('activity')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/orders')->name('orders.')->middleware('activity')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/read-all', [OrderController::class, 'markAllRead'])->name('readAll');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::prefix('admin/messages')->name('messages.')->middleware('activity')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/read-all', [MessageController::class, 'markAllRead'])->name('readAll');
        Route::get('/{message}', [MessageController::class, 'show'])->name('show');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });
});
