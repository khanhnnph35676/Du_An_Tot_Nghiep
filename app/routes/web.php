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
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestimonialController;








// DDawng nhập, đăng kí, đăng xuất, quên mật khẩu


Route::get('login-admin', [AuthenController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('login-admin', [AuthenController::class, 'postLogin'])->name('postLogin');
Route::get('register-admin', [AuthenController::class, 'registerAdmin'])->name('registerAdmin');
Route::post('register-admin', [AuthenController::class, 'postRegister'])->name('postRegister');

 Route::get('password/reset', [AuthenController::class, 'showLinkRequestForm'])->name('password.request');
 Route::post('password/email', [AuthenController::class, 'sendResetLinkEmail'])->name('password.email');
 Route::get('password/reset/{token}', [AuthenController::class, 'showResetForm'])->name('password.reset');
 Route::post('password/reset', [AuthenController::class, 'reset'])->name('password.update');


// Trang amdin
//check đăng nhập
Route::middleware(['auth.check'])->group(function () {
Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
    Route::post('logout', [AuthenController::class, 'logout'])->name('logout');
    // trang chủ
    Route::get('/', function () {   
        return view('admin.home');
    })->name('admin1');
    // Trang san phẩm
    Route::get('list-product',[ProductController::class,'listProducts'])->name('listProducts');
    Route::get('product-detail',[ProductController::class,'productDetail'])->name('productDetail');
    Route::get('product-simple',[ProductController::class,'productSimple'])->name('productSimple');
    Route::get('update-product-simple/{type}/{idProduct}',[ProductController::class,'formUpdateProductSimple'])->name('formUpdateProductSimple');
    // code dữ liệu trang sản phẩm
    Route::post('add-product-simple',[ProductController::class,'addProductSimple'])->name('addProductSimple');
    Route::patch('update-product-simple/{idProduct}',[ProductController::class,'updateProductSimple'])->name('updateProductSimple');
    Route::delete('delete-product-simple',[ProductController::class,'deleteProductSimple'])->name('deleteProductSimple');





    // Trang danh mục
  
    Route::resource('categories', CategoryController::class);
    Route::get('list-categories',[CategoryController::class,'listCategories'])->name('listCategories');

    // Trang customer
    Route::get('list-customer', [CustomerController::class, 'listCustomer'])->name('listCustomer');
    Route::post('customer-store', [CustomerController::class, 'customerStore'])->name('customerStore');
    Route::get('customer-create', [CustomerController::class, 'customerCreate'])->name('customerCreate');
    Route::get('customer-edit/{id}', [CustomerController::class, 'customerEdit'])->name('customerEdit');
    Route::put('customer-update/{id}', [CustomerController::class, 'customerUpdate'])->name('customerUpdate');
    Route::delete('customer-destroy/{id}', [CustomerController::class, 'customerDestroy'])->name('customerDestroy');
    
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
    Route::get('create-discounts',[DiscountController::class, 'createDiscount'])->name('createDiscount');
    Route::post('storeDiscount', [DiscountController::class, 'storeDiscount'])->name('discount.store');
    Route::get('update-discounts/{id}', [DiscountController::class, 'updateDiscount'])->name('updateDiscount');
    Route::put('editDiscount/{id}', [DiscountController::class, 'update'])->name('discount.update');
    Route::delete('deleteDiscount/{id}', [DiscountController::class, 'destroy'])->name('discount.destroy');

    // Quản lý thanh toán
    Route::get('form-payment',[PaymentController::class,'formPayment'])->name('formPayment');
    // quản lý blog
    Route::get('/blog', [BlogController::class, 'index'])->name('admin.blog.list');
// quản lý testimonial
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.list');
});
});