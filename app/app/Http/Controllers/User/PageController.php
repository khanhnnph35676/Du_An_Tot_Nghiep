<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function storeHome()
    {
        $products = Product::latest()->take(8)->get();
        $bestViewedProducts = Product::orderBy('view', 'desc')->take(9)->get();
        $categories = Category::all();
        return view('user.home', compact('products', 'categories', 'bestViewedProducts'));
    }


    public function storeListProduct()
    {
        $products = Product::with('categories')->paginate(12);
        $categories = Category::all();
        $bestProducts = Product::orderBy('view', 'desc')->take(6)->get();

        return view('user.product.list', compact('products', 'categories', 'bestProducts'));
    }

    public function storeProductDetail($id)
    {
        // Lấy chi tiết sản phẩm
        $product = Product::with('categories')->findOrFail($id);

        // Lấy sản phẩm liên quan cùng danh mục (trừ sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $id)
                                    ->take(6)
                                    ->get();

        return view('user.product.detail', compact('product', 'relatedProducts'));
    }


    public function storeListCart()
    {
        // Lấy 6 sản phẩm nổi bật
        $bestProducts = Product::orderBy('view', 'desc')->take(6)->get();

        return view('user.cart.list', compact('bestProducts'));
    }
    public function storeCheckout(){
        return view('user.cart.checkout');
    }
    public function storeTestimonial(){
        return view('user.testimonial');
    }
    public function storeContact(){
        return view('user.contact');
    }

}
