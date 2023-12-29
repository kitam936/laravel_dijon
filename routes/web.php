<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\ReportController;


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
    return view('user.auth.login');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth:users', 'verified'])->name('dashboard');



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
    Route::get('search_m_form', [CompanyController::class, 'search_form_m_sales'])->name('company.search_m_form');
    Route::get('search_w_form', [CompanyController::class, 'search_form_w_sales'])->name('company.search_w_form');
    Route::get('search_u_form', [CompanyController::class, 'search_form_u_sales'])->name('company.search_u_form');
    Route::get('search_s_form', [CompanyController::class, 'search_form_s_sales'])->name('company.search_s_form');
    Route::get('search_h_form', [CompanyController::class, 'search_form_h_sales'])->name('company.search_h_form');
    Route::get('search_uz_form', [CompanyController::class, 'search_form_uz_stocks'])->name('company.search_uz_form');
    Route::get('search_sz_form', [CompanyController::class, 'search_form_sz_stocks'])->name('company.search_sz_form');
    Route::get('search_hz_form', [CompanyController::class, 'search_form_hz_stocks'])->name('company.search_hz_form');
    Route::get('shopmonthrysales/{shop}', [ShopController::class, 'monthrysales'])->name('shop.shopmonthrysales');
    Route::get('shopweeklysales/{shop}', [ShopController::class, 'weeklysales'])->name('shop.shopweeklysales');
    Route::get('sh_stock/{shop}', [ShopController::class, 'sh_stock'])->name('shop.sh_stock');
    Route::get('su_stock/{shop}', [ShopController::class, 'su_stock'])->name('shop.su_stock');
    Route::get('s_season_stock/{shop}', [ShopController::class, 's_season_stock'])->name('shop.s_season_stock');
    Route::get('sh_sales/{shop}', [ShopController::class, 'sh_sales'])->name('shop.sh_sales');
    Route::get('su_sales/{shop}', [ShopController::class, 'su_sales'])->name('shop.su_sales');
    Route::get('s_season_sales/{shop}', [ShopController::class, 's_season_sales'])->name('shop.s_season_sales');
    Route::get('s_search_m_form', [ShopController::class, 's_search_form_m_sales'])->name('shop.s_search_m_form');
    Route::get('s_search_w_form', [ShopController::class, 's_search_form_w_sales'])->name('shop.s_search_w_form');
    Route::get('s_search_u_form', [ShopController::class, 's_search_form_u_sales'])->name('shop.s_search_u_form');
    Route::get('s_search_s_form', [ShopController::class, 's_search_form_s_sales'])->name('shop.s_search_s_form');
    Route::get('s_search_h_form', [ShopController::class, 's_search_form_h_sales'])->name('shop.s_search_h_form');
    Route::get('s_search_uz_form', [ShopController::class, 's_search_form_uz_stocks'])->name('shop.s_search_uz_form');
    Route::get('s_search_sz_form', [ShopController::class, 's_search_form_sz_stocks'])->name('shop.s_search_sz_form');
    Route::get('s_search_hz_form', [ShopController::class, 's_search_form_hz_stocks'])->name('shop.s_search_hz_form');
    Route::get('shop_form/{shop}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('product_index', [ProductController::class, 'index'])->name('product.index');
    Route::get('product_h_shop_zaiko/{hinban}', [ProductController::class, 'h_shop_zaiko'])->name('product.h_shop_zaiko');
    Route::get('report_list', [ReportController::class, 'report_list'])->name('shop.report_list');
    Route::get('report_detail/{id}', [ReportController::class, 'report_detail'])->name('shop.report_detail');
    Route::get('report_create', [ReportController::class, 'report_create'])->name('shop.report_create');
    Route::get('report_store', [ReportController::class, 'report_store'])->name('shop.report_store');
    Route::post('report_store', [ReportController::class, 'report_store'])->name('shop.report_store');
    Route::get('report_edit/{report}', [ReportController::class, 'report_edit'])->name('shop.report_edit');
    Route::get('report_update/{report}', [ReportController::class, 'report_update'])->name('shop.report_update');
    Route::post('report_update/{report}', [ReportController::class, 'report_update'])->name('shop.report_update');
    Route::delete('report_destroy/{report}', [ReportController::class, 'report_destroy'])->name('shop.report_destroy');
});

Route::resource('shop', ShopController::class)
->middleware('auth:users');

Route::resource('company', CompanyController::class)
->middleware('auth:users');



Route::middleware('auth:users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
