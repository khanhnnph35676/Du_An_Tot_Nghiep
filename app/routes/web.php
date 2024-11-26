<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;


// DDawng nhập, đăng kí, đăng xuất, quên mật khẩu
//controller bên store
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\AuthenController;

Route::get('login-admin', [AuthenController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('login-admin', [AuthenController::class, 'postLoginAdmin'])->name('postLogin');
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
    // web.php
    Route::get('get-variant-data', [ProductController::class, 'getVariantData']);
    Route::get('product-simple',[ProductController::class,'productSimple'])->name('productSimple');
    Route::get('update-product-simple/{type}/{idProduct}',[ProductController::class,'formUpdateProductSimple'])->name('formUpdateProductSimple');

    // code dữ liệu trang sản phẩm
    Route::post('add-product-simple',[ProductController::class,'addProductSimple'])->name('addProductSimple');
    Route::patch('update-product-simple/{idProduct}',[ProductController::class,'updateProductSimple'])->name('updateProductSimple');
    Route::delete('delete-product-simple',[ProductController::class,'deleteProductSimple'])->name('deleteProductSimple');
    Route::delete('delete-product-variant',[ProductController::class,'deleteVariant'])->name('deleteVariant');

    //Code bên biến thể
    Route::post('add-product-configurable',[ProductController::class,'addProductConfigurable'])->name('addProductConfigurable');
    Route::get('update-product-configurable/{type}/{idProduct}',[ProductController::class,'formUpdateProductConfigurable'])->name('formUpdateProductConfigurable');
    Route::patch('update-product-configurable/{idProduct}',[ProductController::class,'updateProductConfigurable'])->name('updateProductConfigurable');

    // restore
    Route::get('restore-product',[ProductController::class,'restorProduct'])->name('restorProduct');
    Route::patch('product-restore-action',[ProductController::class,'restoreAction'])->name('restoreAction');
    Route::patch('variant-restore-action',[ProductController::class,'restoreVariantAction'])->name('restoreVariantAction');
    Route::delete('force-delete-product',[ProductController::class,'forceDeleteProduct'])->name('forceDeleteProduct');
    Route::delete('force-delete-variant',[ProductController::class,'forceDeleteVariant'])->name('forceDeleteVariant');

    // Trang danh mục
    Route::resource('categories', CategoryController::class);
    Route::get('list-categories',[CategoryController::class,'listCategories'])->name('listCategories');
    Route::get('list-categories-deleted',[CategoryController::class,'listDeletedCategories'])->name('categories.deleted');
    Route::post('restore-categories',[CategoryController::class,'restore'])->name('categories.restore');
    Route::delete('delete-categories',[CategoryController::class,'forceDestroy'])->name('categories.forceDestroy');
    Route::get('categorie-edit/{id}',[CategoryController::class,'editCategory'])->name('categories.edit');
    Route::patch('categorie-edit/{id}',[CategoryController::class,'pathchEditCategory'])->name('categories.update');

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

    // Quản lý đơn hàng
    Route::get('list-orders',[OrderController::class,'listOrders'])->name('listOrders');
    Route::get('order-detail/{order_id}',[OrderController::class,'orderDetail'])->name('orderDetail');
    Route::post('order-update/{order_id}',[OrderController::class,'updateOrder'])->name('updateOrder');
    // Quản lý giảm giá
    Route::get('list-discounts',[DiscountController::class,'listDiscounts'])->name('listDiscounts');
    Route::get('create-discounts',[DiscountController::class, 'createDiscount'])->name('createDiscount');
    Route::post('storeDiscount', [DiscountController::class, 'storeDiscount'])->name('discount.store');
    Route::get('update-discounts/{id}', [DiscountController::class, 'updateDiscount'])->name('updateDiscount');
    Route::put('editDiscount/{id}', [DiscountController::class, 'update'])->name('discount.update');
    Route::delete('deleteDiscount/{id}', [DiscountController::class, 'destroy'])->name('discount.destroy');

    // Quản lý phương thức thanh toán
    Route::get('form-payment',[PaymentController::class,'formPayment'])->name('formPayment');
    Route::get('create-payments', [PaymentController::class, 'createPayment'])->name('createPayment');
    Route::post('storePayment', [PaymentController::class, 'storePayment'])->name('payment.store');
    Route::get('update-payment/{id}', [PaymentController::class, 'updatePayment'])->name('updatePayment');
    Route::put('editPayment/{id}', [PaymentController::class, 'update'])->name('payment.update');
    Route::delete('deletePayment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');

    // quản lý blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.list');
    Route::get('/blog-category', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/blog-category', [BlogController::class, 'category'])->name('blog.category'); // Lấu danh mục blog
    Route::get('/blog-category-with-blog/{id}', [BlogController::class, 'categoryWithBlog'])->name('blog.category.list');// Lấu danh mục blog và tên blog
    Route::post('storeBlog', [BlogController::class, 'storeBlog'])->name('blog.store'); //Lưu danh mục blog
    Route::put('editBlog/{id}', [BlogController::class, 'update'])->name('blog.category.update');// Sửa tên danh mục category
    Route::delete('blog-categories-destroy/{id}', [BlogController::class, 'Blog_categories_destroy'])->name('blog.categories.destroy');//Xóa danh mục Blog
    // quản lý testimonial
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.list');
    });
});
Route::get('/',[PageController :: class,'storeHome'])->name('storeHome');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('list-product',[PageController :: class,'storeListProduct'])->name('storeListProduct');
Route::get('/product/{id}', action: [PageController::class, 'storeProductDetail'])->name('product.detail');
Route::get('store-contact',[PageController :: class,'storeContact'])->name('storeContact');
Route::get('store-tetimonial',[PageController :: class,'storeTestimonial'])->name('storeTestimonial');


Route::delete('remove-item-cart-detail/{product_id}', [CartController::class, 'removeItemCartDetail'])->name('removeItemCartDetail');
Route::delete('remove-item-cart/{product_variant_id}', [CartController::class, 'removeItemCart'])->name('removeItemCart');
Route::post('add-to-cart',[CartController :: class,'addToCart'])->name('addToCart');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('updateCart');
Route::post('/update-selected-product', [CartController::class, 'updateSelectedProduct'])->name('updateSelectedProduct');


Route::get('store-list-cart',[PageController :: class,'storeListCart'])->name('storeListCart');


Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
Route::get('/order-history', [UserOrderController::class, 'index'])->name('order.history');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.list');
Route::get('/blog-category', [BlogController::class, 'category'])->name('blog.category');

//Login
Route::get('/user/login', [AuthenController::class, 'loginHome'])->name('user.login');
Route::get('/user/register', [AuthenController::class, 'registerHome'])->name('user.register');
Route::post('/user/login', [AuthenController::class, 'postLogin'])->name('user.postLogin');
Route::get('/user/forgot-password', [AuthenController::class, 'forgotPassword'])->name('user.forgot-password');
Route::post('/user/logout', [AuthenController::class, 'logoutUser'])->name('logoutUser');

// địa chỉ người dùng
Route::delete('/address/{id}', [AuthenController::class, 'destroy'])->name('address.destroy');
Route::post('/address', [AuthenController::class, 'store'])->name('address.store');

Route::post('add-order', [CheckoutController::class, 'AddOrder'])->name('AddOrder');
Route::post('momo_payment', [CheckoutController::class, 'momoPayment'])->name('momoPayment');
<<<<<<< HEAD
Route::get('store-checkout',[CheckoutController :: class,'storeCheckout'])->name('storeCheckout');
=======

// search và lọc giá


Route::get('/products', [ProductController::class, 'productList'])->name('products.list');
>>>>>>> master
