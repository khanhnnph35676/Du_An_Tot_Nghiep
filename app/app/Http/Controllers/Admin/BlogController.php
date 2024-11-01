<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog_categories;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết từ cơ sở dữ liệu (nếu có)
        $posts = []; // Thay thế bằng logic lấy dữ liệu từ model
        return view('admin.blog.list', compact('posts'));
    }
    public function category( ){
        $blog_categories = Blog_categories::all();
        return view('admin.blog.category', compact('blog_categories'));
        
    }
}
