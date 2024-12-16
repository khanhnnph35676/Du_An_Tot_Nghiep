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
use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\VariantOptionController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\VoucherController;

use App\Http\Controllers\User\UserBlogController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\AuthenController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\ChatController;




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
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        // đăng xuất
        Route::post('logout', [AuthenController::class, 'logout'])->name('logout');

        // TRANG CHỈ CHO ADMIN THỰC HIỆN, CÒN CÁC TRANG NGOÀI NHÂN VIÊN THỰC HIỆN
        Route::middleware(['checkrule'])->group(function () {
            // Trang customer
            Route::get('list-customer', [CustomerController::class, 'listCustomer'])->name('listCustomer');
            Route::post('customer-store', [CustomerController::class, 'customerStore'])->name('customerStore');
            Route::get('customer-create', [CustomerController::class, 'customerCreate'])->name('customerCreate');
            Route::get('customer-edit/{id}', [CustomerController::class, 'customerEdit'])->name('customerEdit');
            Route::put('customer-update/{id}', [CustomerController::class, 'customerUpdate'])->name('customerUpdate');
            Route::delete('customer-destroy/{id}', [CustomerController::class, 'customerDestroy'])->name('customerDestroy');


            // quản lý nhân viên
            Route::get('list-employees', [CustomerController::class, 'listEmployees'])->name('listEmployees');

            // Quản lý giảm giá
            Route::get('list-discounts', [DiscountController::class, 'listDiscounts'])->name('listDiscounts');
            Route::get('create-discounts', [DiscountController::class, 'createDiscount'])->name('createDiscount');
            Route::post('storeDiscount', [DiscountController::class, 'storeDiscount'])->name('discount.store');
            Route::get('update-discounts/{id}', [DiscountController::class, 'updateDiscount'])->name('updateDiscount');
            Route::put('editDiscount/{id}', [DiscountController::class, 'update'])->name('discount.update');
            Route::delete('deleteDiscount/{id}', [DiscountController::class, 'destroy'])->name('discount.destroy');

            // Quản lý phương thức thanh toán
            Route::get('form-payment', [PaymentController::class, 'formPayment'])->name('formPayment');
            Route::get('create-payments', [PaymentController::class, 'createPayment'])->name('createPayment');
            Route::post('storePayment', [PaymentController::class, 'storePayment'])->name('payment.store');
            Route::get('update-payment/{id}', [PaymentController::class, 'updatePayment'])->name('updatePayment');
            Route::put('editPayment/{id}', [PaymentController::class, 'update'])->name('payment.update');
            Route::delete('deletePayment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');

            // điểm thưởng
            Route::get('list-point', [PointController::class, 'index'])->name('listPoints');
            Route::get('update-point/{id}', [PointController::class, 'updatePoint'])->name('updatePoint');
            Route::patch('update-point', [PointController::class, 'updatePatchPoint'])->name('updatePatchPoint');
        });

        // chat
        Route::get('list-chat', [ChatController::class, 'index'])->name('listChat');

        // trang chủ
        Route::get('/', [StatisticsController::class, 'index'])->name('admin1');
        Route::get('/statistics', [StatisticsController::class, 'chart'])->name('chart');

        // Trang san phẩm
        Route::get('list-product', [ProductController::class, 'listProducts'])->name('listProducts');
        Route::get('product-detail', [ProductController::class, 'productDetail'])->name('productDetail');
        Route::get('get-variant-data', [ProductController::class, 'getVariantData']);
        Route::get('product-simple', [ProductController::class, 'productSimple'])->name('productSimple');
        Route::get('update-product-simple/{type}/{idProduct}', [ProductController::class, 'formUpdateProductSimple'])->name('formUpdateProductSimple');

        // code dữ liệu trang sản phẩm
        Route::post('add-product-simple', [ProductController::class, 'addProductSimple'])->name('addProductSimple');
        Route::patch('update-product-simple/{idProduct}', [ProductController::class, 'updateProductSimple'])->name('updateProductSimple');
        Route::delete('delete-product-simple', [ProductController::class, 'deleteProductSimple'])->name('deleteProductSimple');
        Route::delete('delete-product-variant', [ProductController::class, 'deleteVariant'])->name('deleteVariant');

        //Code bên biến thể
        Route::post('add-product-configurable', [ProductController::class, 'addProductConfigurable'])->name('addProductConfigurable');
        Route::get('update-product-configurable/{type}/{idProduct}', [ProductController::class, 'formUpdateProductConfigurable'])->name('formUpdateProductConfigurable');
        Route::patch('update-product-configurable/{idProduct}', [ProductController::class, 'updateProductConfigurable'])->name('updateProductConfigurable');

        // restore
        Route::get('restore-product', [ProductController::class, 'restorProduct'])->name('restorProduct');
        Route::patch('product-restore-action', [ProductController::class, 'restoreAction'])->name('restoreAction');
        Route::patch('variant-restore-action', [ProductController::class, 'restoreVariantAction'])->name('restoreVariantAction');
        Route::delete('force-delete-product', [ProductController::class, 'forceDeleteProduct'])->name('forceDeleteProduct');
        Route::delete('force-delete-variant', [ProductController::class, 'forceDeleteVariant'])->name('forceDeleteVariant');

        // Trang danh mục
        Route::resource('categories', CategoryController::class);
        Route::get('list-categories', [CategoryController::class, 'listCategories'])->name('listCategories');
        Route::get('list-categories-deleted', [CategoryController::class, 'listDeletedCategories'])->name('categories.deleted');
        Route::post('restore-categories', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('delete-categories', [CategoryController::class, 'forceDestroy'])->name('categories.forceDestroy');
        Route::get('categorie-edit/{id}', [CategoryController::class, 'editCategory'])->name('categories.edit');
        Route::patch('categorie-edit/{id}', [CategoryController::class, 'pathchEditCategory'])->name('categories.update');

        // trang app
        Route::get('calender', [AppController::class, 'calender'])->name('calender');
        Route::get('profile', [AppController::class, 'profile'])->name('profile');
        Route::get('inbox', [AppController::class, 'inbox'])->name('inbox');
        Route::get('compose', [AppController::class, 'compose'])->name('compose');
        Route::get('read-email', [AppController::class, 'readEmail'])->name('readEmail');

        // Quản lý đơn hàng
        Route::get('list-orders', [OrderController::class, 'listOrders'])->name('listOrders');
        Route::get('order-detail/{order_id}', [OrderController::class, 'orderDetail'])->name('orderDetail');
        Route::post('order-update/{order_id}', [OrderController::class, 'updateOrder'])->name('updateOrder');

        // MessagesController

        Route::delete('/admin/messages/{id}', [MessagesController::class, 'deleteMessage'])->name('deleteMessage');
        // quản lý blog
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.list');
        Route::post('/submit-add-blog', [BlogController::class, 'submit_add_blog'])->name('submit_add_blog'); // Thêm blog
        Route::patch('/submit-edit-blog/{idBlog}', [BlogController::class, 'submit_edit_blog'])->name('blog.submit-edit-blog');; // Sửa blog
        Route::get('/edit-blog/{idBlog}', [BlogController::class, 'edit_blog'])->name('blog.edit_blog');
        Route::get('/admin/blog/{BlogSlug}', [BlogController::class, 'blog_details'])->name('blog.blog_details');
        Route::delete('/admin/blog', [BlogController::class, 'destroy'])->name('blog.delete');

        Route::get('variant-options', [VariantOptionController::class, 'index'])->name('variant-options.index');
        Route::get('variant-options/create', [VariantOptionController::class, 'create'])->name('variant-options.create');
        Route::post('variant-options', [VariantOptionController::class, 'store'])->name('variant-options.store');
        Route::get('variant-options/{id}/edit', [VariantOptionController::class, 'edit'])->name('variant-options.edit');
        Route::put('variant-options/{id}', [VariantOptionController::class, 'update'])->name('variant-options.update');

        Route::delete('variant-options/{variantOption}', [VariantOptionController::class, 'destroy'])->name('variant-options.destroy');

        // voucher
        Route::resource('vouchers', VoucherController::class);
        // Quản lý danh mục bài viết
        Route::get('/blog-categories', [BlogCategoryController::class, 'list_categories'])->name('blog.categories.list'); // Danh sách danh mục
        Route::get('/blog-categories/create', [BlogCategoryController::class, 'create_category'])->name('blog.categories.create'); // Form thêm danh mục
        Route::post('/blog-categories/store', [BlogCategoryController::class, 'store_category'])->name('blog.categories.store'); // Xử lý thêm danh mục
        Route::get('/blog-categories/edit/{id}', [BlogCategoryController::class, 'edit_category'])->name('blog.categories.edit'); // Form chỉnh sửa danh mục
        Route::patch('/blog-categories/update/{id}', [BlogCategoryController::class, 'update_category'])->name('blog.categories.update'); // Xử lý cập nhật danh mục
        Route::delete('/blog-categories/delete/{id}', [BlogCategoryController::class, 'destroy_category'])->name('blog.categories.destroy'); // Xóa danh mục

        // quản lý testimonial
        Route::get('/testimonials', [TestimonialController::class, 'listTestimonial'])->name('testimonials');
        Route::get('/create-testimonial', [TestimonialController::class, 'createTestimonial'])->name('createTestimonial');
        Route::post('/create-testimonial', [TestimonialController::class, 'StoreTestimonial'])->name('StoreTestimonial');
        Route::get('/edit-testimonial/{id}', [TestimonialController::class, 'editTestimonial'])->name('editTestimonial');
        Route::patch('/edit-testimonial', [TestimonialController::class, 'updateTestimonial'])->name('updateTestimonial');
        Route::delete('/delete-testimonial', [TestimonialController::class, 'deleteTestimonial'])->name('deleteTestimonial');
    });
});



// TRANG KHÔNG CÓ TÀI KHOẢN CŨNG CÓ THỂ VÀO (TÀI KHOẢN QUẢN LÝ WEB KHÔNG CHO VÀO)
Route::middleware(['checkadmin'])->group(function () {
    // trang chủ
    Route::get('/', [PageController::class, 'storeHome'])->name('storeHome');
    // comment
    Route::get('/product/{id}/testimonials', [TestimonialController::class, 'getProductTestimonials'])->name('product.testimonials');
    //trang tren header footer
    Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');
    Route::get('/sales-and-refunds', [PageController::class, 'salesAndRefunds'])->name('sales-and-refunds');
    Route::get('/return-policy', [PageController::class, 'returnPolicy'])->name('return-policy');
    Route::get('/faq-and-support', [PageController::class, 'faqAndSupport'])->name('faq-and-support');
    //Sản phẩm
    Route::get('list-product', [PageController::class, 'storeListProduct'])->name('storeListProduct');
    Route::get('/product/{id}', action: [PageController::class, 'storeProductDetail'])->name('product.detail');
    Route::get('store-contact', [PageController::class, 'storeContact'])->name('storeContact');
    Route::get('store-tetimonial', [PageController::class, 'storeTestimonial'])->name('storeTestimonial');
    Route::get('store-intro', [PageController::class, 'storeIntro'])->name('storeIntro');

    // giỏ hàng
    Route::get('store-list-cart', [PageController::class, 'storeListCart'])->name('storeListCart');
    Route::delete('remove-item-cart-detail/{product_id}', [CartController::class, 'removeItemCartDetail'])->name('removeItemCartDetail');
    Route::delete('remove-item-cart/{product_variant_id}', [CartController::class, 'removeItemCart'])->name('removeItemCart');
    Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('add-to-cart-detail/{checkAdd}', [CartController::class, 'addToCartDetai'])->name('addToCartDetai');

    //Trang thanh toán
    Route::get('store-checkout', [CheckoutController::class, 'storeCheckout'])->name('storeCheckout');

    //Sửa số lượng trong giỏ hàng
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('updateCart');
    Route::post('/update-selected-product', [CartController::class, 'updateSelectedProduct'])->name('updateSelectedProduct');
    Route::post('/updateCartNonVariant', [CartController::class, 'updateCartNonVariant'])->name('updateCartNonVariant');
    Route::post('/update-qty-cart-variant', [CartController::class, 'updateQtyCartVariant'])->name('updateQtyCartVariant');

    // địa chỉ người dùng
    Route::delete('/address/{id}', [AuthenController::class, 'destroy'])->name('address.destroy');
    Route::post('/address', [AuthenController::class, 'store'])->name('address.store');

    // thao tác thanh toán
    Route::post('add-order', [CheckoutController::class, 'AddOrder'])->name('AddOrder');
    Route::post('momo_payment', [CheckoutController::class, 'momoPayment'])->name('momoPayment');
    Route::patch('order-update-destroy', [UserOrderController::class, 'destroyOrder'])->name('destroyOrder');

    // Bài viết
    Route::prefix('blogs')->group(function () {
        Route::get('/', [UserBlogController::class, 'index'])->name('user.blog.index');
        Route::get('/{BlogSlug}', [UserBlogController::class, 'show'])->name('user.blog.detail');

    });

    // TRANG CÓ TÀI KHOẢN NGƯỜI DÙNG MỚI CHO VÀO
    Route::middleware(['checkuser'])->group(function () {
        //Trang thông tin khách hàng
        Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
        Route::patch('/update-profile', [UserProfileController::class, 'updateProfile'])->name('updateProfile');
        Route::get('list-points', [UserProfileController::class, 'points'])->name('points');
        Route::post('add-voucher', [UserProfileController::class, 'addVoucher'])->name('addVoucher');
        Route::get('/order-history', [UserOrderController::class, 'index'])->name('order.history');
        Route::get('/order-detail/{order_id}', [UserOrderController::class, 'detail'])->name('order.detail');
        Route::get('/success-checkout',[CheckoutController :: class,'successCheckout'])->name('successCheckout');
        Route::post('/pay-Momo',[CheckoutController :: class,'payMomo'])->name('payMomo');
        Route::get('user/change-password', [AuthController::class, 'changePassword'])->name('user.change-password');
        Route::post('user/update-password', [AuthController::class, 'updatePassword'])->name('user.update-password');

    });

});


//đăng nhập đăng ký, đăng xuất , quên mật khẩu
Route::get('/user/login', [AuthenController::class, 'loginHome'])->name('user.login');
Route::get('/user/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/user/register', [AuthController::class, 'postRegister'])->name('user.postRegister');

Route::post('/user/login', [AuthenController::class, 'postLogin'])->name('user.postLogin');
Route::get('/user/forgot-password', [AuthenController::class, 'forgotPassword'])->name('user.forgot-password');
Route::post('/user/logout', [AuthenController::class, 'logoutUser'])->name('logoutUser');
