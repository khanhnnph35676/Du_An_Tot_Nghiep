<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function storeHome(){
        return view('user.home');
    }
    public function storeListProduct(){
        return view('user.product.list');
    }
    public function storeProductDetail(){
        return view('user.product.detail');
    }
    public function storeListCart(){
        return view('user.cart.list');
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
