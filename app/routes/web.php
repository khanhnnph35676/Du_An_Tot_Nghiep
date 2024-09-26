<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;

// DDawng nhập, đăng kí, đăng xuất, quên mật khẩu

Route::get('login-admin',[AuthenController :: class,'loginAdmin'])->name('loginAdmin');
Route::get('register-admin',[AuthenController :: class,'registerAdmin'])->name('registerAdmin');
// Trang amdin
Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
    // trang chủ
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin1');
    // Trang san phẩm
    Route::get('list-product',[ProductController::class,'listProducts'])->name('listProducts');
    Route::get('product-detail',[ProductController::class,'productDetail'])->name('productDetail');
    // Trang danh mục
    Route::get('list-categories',[CategoryController::class,'listCategories'])->name('listCategories');
    // Trang customer
    Route::get('list-customer',[CustomerController::class,'listCustomer'])->name('listCustomer');
    Route::get('customer-detail',[CustomerController::class,'customerDetail'])->name('customerDetail');

});
