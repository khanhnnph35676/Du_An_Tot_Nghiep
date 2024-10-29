<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết từ cơ sở dữ liệu (nếu có)
        $posts = []; // Thay thế bằng logic lấy dữ liệu từ model

        return view('admin.blog.list', compact('posts'));
    }
}
