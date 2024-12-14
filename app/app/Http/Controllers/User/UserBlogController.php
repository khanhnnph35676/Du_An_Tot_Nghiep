<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class UserBlogController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $blogs = Blog::where('Status', 1)->paginate(8); // Lấy các blog đã được phê duyệt
        return view('user.blog.list', compact('blogs','cart'));
    }

    public function show($BlogSlug)
    {
        $cart = session()->get('cart', []);

        $blog = Blog::where('Status', 1)->where('BlogSlug', $BlogSlug)->firstOrFail(); // Chỉ hiển thị blog có trạng thái được phê duyệt
        return view('user.blog.detail', compact('blog','cart'));
    }
}
