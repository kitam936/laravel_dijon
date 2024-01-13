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

//

Route::get('/', function () {
    return view('user.auth.login');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth:users', 'verified'])->name('dashboard');



Route::
    middleware('auth:users')->group(function () {
    Route::get('shoplist/{company}', [CompanyController::class, 'shoplist'])->name('company.shoplist');
    Route::get('search_m_form', [CompanyController::class, 'search_form_m_sales'])->name('company.search_m_form');
    Route::get('search_w_form', [CompanyController::class, 'search_form_w_sales'])->name('company.search_w_form');
    Route::get('search_u_form', [CompanyController::class, 'search_form_u_sales'])->name('company.search_u_form');
    Route::get('search_s_form', [CompanyController::class, 'search_form_s_sales'])->name('company.search_s_form');
    Route::get('search_h_form', [CompanyController::class, 'search_form_h_sales'])->name('company.search_h_form');
    Route::get('search_md_form', [CompanyController::class, 'search_form_m_deliv'])->name('company.search_md_form');
    Route::get('search_wd_form', [CompanyController::class, 'search_form_w_deliv'])->name('company.search_wd_form');
    Route::get('search_ud_form', [CompanyController::class, 'search_form_u_deliv'])->name('company.search_ud_form');
    Route::get('search_sd_form', [CompanyController::class, 'search_form_s_deliv'])->name('company.search_sd_form');
    Route::get('search_hd_form', [CompanyController::class, 'search_form_h_deliv'])->name('company.search_hd_form');
    Route::get('search_uz_form', [CompanyController::class, 'search_form_uz_stocks'])->name('company.search_uz_form');
    Route::get('search_sz_form', [CompanyController::class, 'search_form_sz_stocks'])->name('company.search_sz_form');
    Route::get('search_hz_form', [CompanyController::class, 'search_form_hz_stocks'])->name('company.search_hz_form');
    Route::get('s_search_m_form', [ShopController::class, 's_search_form_m_sales'])->name('shop.s_search_m_form');
    Route::get('s_search_w_form', [ShopController::class, 's_search_form_w_sales'])->name('shop.s_search_w_form');
    Route::get('s_search_u_form', [ShopController::class, 's_search_form_u_sales'])->name('shop.s_search_u_form');
    Route::get('s_search_s_form', [ShopController::class, 's_search_form_s_sales'])->name('shop.s_search_s_form');
    Route::get('s_search_h_form', [ShopController::class, 's_search_form_h_sales'])->name('shop.s_search_h_form');
    Route::get('s_search_md_form', [ShopController::class, 's_search_form_m_deliv'])->name('shop.s_search_md_form');
    Route::get('s_search_wd_form', [ShopController::class, 's_search_form_w_deliv'])->name('shop.s_search_wd_form');
    Route::get('s_search_ud_form', [ShopController::class, 's_search_form_u_deliv'])->name('shop.s_search_ud_form');
    Route::get('s_search_sd_form', [ShopController::class, 's_search_form_s_deliv'])->name('shop.s_search_sd_form');
    Route::get('s_search_hd_form', [ShopController::class, 's_search_form_h_deliv'])->name('shop.s_search_hd_form');
    Route::get('s_search_uz_form', [ShopController::class, 's_search_form_uz_stocks'])->name('shop.s_search_uz_form');
    Route::get('s_search_sz_form', [ShopController::class, 's_search_form_sz_stocks'])->name('shop.s_search_sz_form');
    Route::get('s_search_hz_form', [ShopController::class, 's_search_form_hz_stocks'])->name('shop.s_search_hz_form');
    Route::get('shop_form/{shop}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('product_index', [ProductController::class, 'index'])->name('product.index');
    Route::get('product_h_shop_zaiko/{hinban}', [ProductController::class, 'h_shop_zaiko'])->name('product.h_shop_zaiko');
    Route::get('report_list', [ReportController::class, 'report_list'])->name('shop.report_list');
    Route::get('report_detail/{id}', [ReportController::class, 'report_detail'])->name('shop.report_detail');
    Route::get('report_create/{shop}', [ReportController::class, 'report_create'])->name('shop.report_create');
    Route::get('report_store', [ReportController::class, 'report_store'])->name('shop.report_store');
    Route::post('report_store', [ReportController::class, 'report_store_rs'])->name('shop.report_store');
    Route::get('report_edit/{report}', [ReportController::class, 'report_edit'])->name('shop.report_edit');
    Route::get('report_update/{report}', [ReportController::class, 'report_update'])->name('shop.report_update');
    Route::post('report_update/{report}', [ReportController::class, 'report_update_rs'])->name('shop.report_update');
    Route::delete('report_destroy/{report}', [ReportController::class, 'report_destroy'])->name('shop.report_destroy');

    Route::get('s_m_form/{shop}', [ShopController::class, 's_form_m_sales'])->name('shop.s_m_form');
    Route::get('s_w_form/{shop}', [ShopController::class, 's_form_w_sales'])->name('shop.s_w_form');
    Route::get('s_u_form/{shop}', [ShopController::class, 's_form_u_sales'])->name('shop.s_u_form');
    Route::get('s_s_form/{shop}', [ShopController::class, 's_form_s_sales'])->name('shop.s_s_form');
    Route::get('s_h_form/{shop}', [ShopController::class, 's_form_h_sales'])->name('shop.s_h_form');
    Route::get('s_md_form/{shop}', [ShopController::class, 's_form_m_deliv'])->name('shop.s_md_form');
    Route::get('s_wd_form/{shop}', [ShopController::class, 's_form_w_deliv'])->name('shop.s_wd_form');
    Route::get('s_ud_form/{shop}', [ShopController::class, 's_form_u_deliv'])->name('shop.s_ud_form');
    Route::get('s_sd_form/{shop}', [ShopController::class, 's_form_s_deliv'])->name('shop.s_sd_form');
    Route::get('s_hd_form/{shop}', [ShopController::class, 's_form_h_deliv'])->name('shop.s_hd_form');
    Route::get('s_uz_form/{shop}', [ShopController::class, 's_form_uz_stocks'])->name('shop.s_uz_form');
    Route::get('s_sz_form/{shop}', [ShopController::class, 's_form_sz_stocks'])->name('shop.s_sz_form');
    Route::get('s_hz_form/{shop}', [ShopController::class, 's_form_hz_stocks'])->name('shop.s_hz_form');
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
