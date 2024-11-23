<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Address;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function storeHome()
    {
        $cart = session()->get('cart', []);
        $products = Product::latest()->take(8)->get();
        $bestViewedProducts = Product::orderBy('view', 'desc')->take(9)->get();
        $categories = Category::all();
        $product_variants = ProductVariant::with("options")->get();
        return view('user.home', compact('products', 'categories', 'bestViewedProducts','product_variants','cart'));
    }


    public function storeListProduct()
    {
        $cart = session()->get('cart', []);
        $products = Product::with('categories')->paginate(12);
        $categories = Category::all();
        $bestProducts = Product::orderBy('view', 'desc')->take(6)->get();

        return view('user.product.list', compact('products', 'categories', 'bestProducts','cart'));
    }

    public function storeProductDetail($id)
    {
        $cart = session()->get('cart', []);
        $product = Product::with('categories')->findOrFail($id);
        $product->update(
            ['view' => $product->view + 1 ]
        );
        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $id)
                                    ->take(6)
                                    ->get();

        return view('user.product.detail', compact('product', 'relatedProducts','cart'));
    }


    public function storeListCart()
    {

        $bestProducts = Product::orderBy('view', 'desc')->take(6)->get();
        // session()->forget('cart');
        $cart = session()->get('cart', []);
        $products = Product::get();
        $productVariants = ProductVariant::get();
        return view('user.cart.list', compact('bestProducts','cart','products','productVariants'));
    }
    public function storeCheckout(){
        $cart = session()->get('cart', []);
        $products = Product::get();
        $address = Address::where('user_id',Auth::user()->id)->get();
        $productVariants = ProductVariant::get();
        return view('user.cart.checkout')->with([
            'address' => $address,
            'cart' => $cart,
            'products' => $products,
            'productVariants' => $productVariants
        ]);
    }
    public function storeTestimonial(){
        $cart = session()->get('cart', []);
        return view('user.testimonial')->with([
            'cart' => $cart]);;
    }
    public function storeContact(){
        $cart = session()->get('cart', []);
        return view('user.contact')->with([
            'cart' => $cart]);;
    }

}
