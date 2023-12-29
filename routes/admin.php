<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DataController;




Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

Route::resource('users', UsersController::class)
->middleware('auth:admin')->except(['show']);

Route::middleware('auth:admin')->group(function () {
    Route::get('/data', [DataController::class, 'create'])->name('data.create');
    Route::get('data/data_index', [DataController::class, 'index'])->name('data.data_index');
    Route::get('data/brand_index', [DataController::class, 'brand_index'])->name('data.brand_index');
    Route::get('data/unit_index', [DataController::class, 'unit_index'])->name('data.unit_index');
    Route::get('data/hinban_index', [DataController::class, 'hinban_index'])->name('data.hinban_index');
    Route::get('data/area_index', [DataController::class, 'area_index'])->name('data.area_index');
    Route::get('data/company_index', [DataController::class, 'company_index'])->name('data.company_index');
    Route::get('data/shop_index', [DataController::class, 'shop_index'])->name('data.shop_index');
    Route::get('data/sales_index', [DataController::class, 'sales_index'])->name('data.sales_index');
    Route::get('data/deliv_index', [DataController::class, 'delivery_index'])->name('data.deliv_index');
    Route::get('data/stock_index', [DataController::class, 'stock_index'])->name('data.stock_index');
    Route::POST('data/stock_upload', [DataController::class, 'stock_upload'])->name('data.stock_upload');
    Route::POST('data/shop_upload', [DataController::class, 'shop_upload'])->name('data.shop_upload');
    Route::POST('data/shop_upsert', [DataController::class, 'shop_upsert'])->name('data.shop_upsert');
    Route::POST('data/sales_upload', [DataController::class, 'sales_upload'])->name('data.sales_upload');
    Route::POST('data/deliv_upload', [DataController::class, 'delivery_upload'])->name('data.deliv_upload');
    Route::POST('data/hinban_upload', [DataController::class, 'hinban_upload'])->name('data.hinban_upload');
    Route::POST('data/hinban_upsert', [DataController::class, 'hinban_upsert'])->name('data.hinban_upsert');
    Route::POST('data/company_upsert', [DataController::class, 'company_upsert'])->name('data.company_upsert');
    Route::POST('data/area_upsert', [DataController::class, 'area_upsert'])->name('data.area_upsert');
    Route::POST('data/unit_upsert', [DataController::class, 'unit_upsert'])->name('data.unit_upsert');
    Route::POST('data/brand_upsert', [DataController::class, 'brand_upsert'])->name('data.brand_upsert');
    Route::get('data/shop_edit/{shop}', [DataController::class, 'shop_edit'])->name('data.shop_edit');
    Route::get('report_update/{shop}', [DataController::class, 'shop_update'])->name('data.shop_update');
    Route::post('report_update/{shop}', [DataController::class, 'shop_update'])->name('data.shop_update');
    Route::delete('report_destroy/{shop}', [DataController::class, 'shop_destroy'])->name('data.shop_destroy');
    Route::get('data/delete_index', [DataController::class, 'delete_index'])->name('data.delete_index');
    Route::delete('sales_destroy', [DataController::class, 'sales_destroy'])->name('data.sales_destroy');
    Route::delete('deliv_destroy', [DataController::class, 'deliv_destroy'])->name('data.deliv_destroy');

});

Route::middleware('auth:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');


});


