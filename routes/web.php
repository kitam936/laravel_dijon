<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Shop\ShopController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.welcome');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth:users', 'verified'])->name('dashboard');


Route::resource('company', CompanyController::class)
->middleware('auth:users');

Route::
    middleware('auth:users')->group(function () {
    Route::get('shoplist/{company}', [CompanyController::class, 'shoplist'])->name('company.shoplist');
    Route::get('monthrysales/{company}', [CompanyController::class, 'monthrysales'])->name('company.monthrysales');
    Route::get('weeklysales/{company}', [CompanyController::class, 'weeklysales'])->name('company.weeklysales');
    Route::get('ch_stock/{company}', [CompanyController::class, 'ch_stock'])->name('company.ch_stock');
    Route::get('cu_stock/{company}', [CompanyController::class, 'cu_stock'])->name('company.cu_stock');
    Route::get('c_season_stock/{company}', [CompanyController::class, 'c_season_stock'])->name('company.c_season_stock');
    Route::get('ch_sales/{company}', [CompanyController::class, 'ch_sales'])->name('company.ch_sales');
    Route::get('cu_sales/{company}', [CompanyController::class, 'cu_sales'])->name('company.cu_sales');
    Route::get('c_season_sales/{company}', [CompanyController::class, 'c_season_sales'])->name('company.c_season_sales');
    Route::get('shopmonthrysales/{shop}', [ShopController::class, 'monthrysales'])->name('shop.shopmonthrysales');
    Route::get('shopweeklysales/{shop}', [ShopController::class, 'weeklysales'])->name('shop.shopweeklysales');
    Route::get('sh_stock/{shop}', [ShopController::class, 'sh_stock'])->name('shop.sh_stock');
    Route::get('su_stock/{shop}', [ShopController::class, 'su_stock'])->name('shop.su_stock');
    Route::get('s_season_stock/{shop}', [ShopController::class, 's_season_stock'])->name('shop.s_season_stock');
    Route::get('sh_sales/{shop}', [ShopController::class, 'sh_sales'])->name('shop.sh_sales');
    Route::get('su_sales/{shop}', [ShopController::class, 'su_sales'])->name('shop.su_sales');
    Route::get('s_season_sales/{shop}', [ShopController::class, 's_season_sales'])->name('shop.s_season_sales');

});

Route::resource('shop', ShopController::class)
->middleware('auth:users');



Route::middleware('auth:users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
