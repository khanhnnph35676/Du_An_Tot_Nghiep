<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\User\AuthenController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PaymentController;
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
    // trang app
    Route::get('calender',[AppController::class,'calender'])->name('calender');
    Route::get('profile',[AppController::class,'profile'])->name('profile');
    Route::get('inbox',[AppController::class,'inbox'])->name('inbox');
    Route::get('compose',[AppController::class,'compose'])->name('compose');
    Route::get('read-email',[AppController::class,'readEmail'])->name('readEmail');
    // Quản lý cửa hàng
    Route::get('list-orders',[OrderController::class,'listOrders'])->name('listOrders');
    Route::get('order-detail',[OrderController::class,'orderDetail'])->name('orderDetail');
    // Quản lý giảm giá
    Route::get('list-discounts',[DiscountController::class,'listDiscounts'])->name('listDiscounts');
    Route::get('discounts-detail',[DiscountController::class,'discountDetail'])->name('discountDetail');
    // Quản lý thanh toán
    Route::get('form-payment',[PaymentController::class,'formPayment'])->name('formPayment');

});
