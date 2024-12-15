<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Address;
use App\Models\ProductVariant;
use App\Models\Payment;
use App\Models\Gallerie;

use App\Models\DiscountProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function storeIntro(){
        session()->forget('checkOrder');
        $cart = session()->get('cart', []);
        return view('user.introduct')->with('cart', $cart);
    }
    public function storeHome()
    {
        $cart = session()->get('cart', []);
        // dd($cart);
        $products = Product::latest()->take(8)->get();
        $bestViewedProducts = Product::orderBy('view', 'desc')->take(9)->get();
        $categories = Category::all();
        $product_variants = ProductVariant::with("options")->get();

        $discount = DiscountProduct::with("discounts")->get();
        // session()->flush();
        // session()->forget('addresses');
        session()->forget('checkOrder');
        return view('user.home', compact('products', 'categories', 'bestViewedProducts','product_variants','cart','discount'));

    }

    public function storeListProduct(Request $request)
    {
        $cart = session()->get('cart', []);

        // Initialize the query for products
        $query = Product::query();

        // Filter by search keyword
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by price
        if ($request->has('price') && $request->price) {
            $query->where('price', '<=', $request->price);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Get the filtered products
        $products = $query->paginate(12);
        $categories = Category::all();
        $bestProducts = Product::orderBy('view', 'desc')->take(6)->get();
        session()->forget('checkOrder');
        return view('user.product.list', compact('products', 'categories', 'bestProducts', 'cart'));
    }

    public function storeProductDetail($id)
    {
        session()->forget('checkOrder');
        $galleries = Gallerie::where('product_id',$id)->get();

        $discount = DiscountProduct::with("discounts")->where('product_id',$id)->first();

        $cart = session()->get('cart', []);
        $product = Product::with('categories')->findOrFail($id);
        $productVariant =  ProductVariant::with('options')->where('product_id', $id)->get();
        $product->update(
            ['view' => $product->view + 1 ]
        );

        // sản phẩm liên quan
        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $id)
                                    ->take(6)
                                    ->get();
        session()->forget('checkOrder');
        return view('user.product.detail', compact('product', 'relatedProducts','cart','productVariant','galleries','discount'));
    }

    public function storeListCart()
    {
        $cart = session()->get('cart', []);
        // dd($cart);

        $bestProducts = Product::orderBy('view', 'desc')->take(6)->get();
        // session()->forget('cart');
        session()->forget('checkOrder');
        $products = Product::get();
        $productVariants = ProductVariant::get();
        return view('user.cart.list', compact('bestProducts','cart','products','productVariants'));
    }
    public function storeTestimonial(){
        $cart = session()->get('cart', []);
        session()->forget('checkOrder');
        return view('user.testimonial')->with([
            'cart' => $cart]);;
    }
    public function storeContact(){
        session()->forget('checkOrder');
        $cart = session()->get('cart', []);
        return view('user.contact')->with([
            'cart' => $cart]);;
    }

    public function privacyPolicy()
    {
        $cart = session()->get('cart', []);
        return view('user.pages.privacy-policy',compact('cart'));
    }

    /**
     * Hiển thị trang Điều khoản.
     */
    public function termsAndConditions()
    {
        $cart = session()->get('cart', []);
        return view('user.pages.terms-and-conditions',compact('cart'));
    }

    /**
     * Hiển thị trang Bán hàng và hoàn tiền.
     */
    public function salesAndRefunds()
    {
        $cart = session()->get('cart', []);
        return view('user.pages.sales-and-refunds',compact('cart'));
    }

    /**
     * Hiển thị trang Chính sách đổi trả.
     */
    public function returnPolicy()
    {
        $cart = session()->get('cart', []);
        return view('user.pages.return-policy',compact('cart'));
    }

    /**
     * Hiển thị trang Câu hỏi thường gặp và Hỗ trợ.
     */
    public function faqAndSupport()
    {
        $cart = session()->get('cart', []);
        return view('user.pages.faq-and-support',compact('cart'));
    }
}
