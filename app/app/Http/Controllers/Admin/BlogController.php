<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoriesRequest;
use App\Models\Blog_categories;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Block;

class BlogController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết từ cơ sở dữ liệu (nếu có)
        $posts = []; // Thay thế bằng logic lấy dữ liệu từ model
        return view('admin.blog.list', compact('posts'));
    }
    public function category( ){
        $blog_categories = Blog_categories::paginate(5);
        return view('admin.blog.category', compact('blog_categories'));
    }

    public function storeBlog(BlogCategoriesRequest $request)//lưu danh mục bài viết
    {
        $data = $request->all();
        Blog_categories::query()->create($data);
        return redirect()->route('admin.blog.category')->with('insert-message', 'Thêm dữ liệu thành công');
    }
    public function Blog_categories_destroy(Request $request)// Xóa danh mục bài viết
    {
        $blog_category = Blog_categories::find($request->id);
        $blog_category->delete();
        return redirect()->route('admin.blog.category')->with('delete-message', 'Xóa dữ liệu thành công');
    }

    public function update(BlogCategoriesRequest $request)
    {
        // $data = $request->all();
        $data = $request->except('_token', '_method');
        Blog_categories::where('id', $request->id)->update($data);
        return redirect()->back()->with('insert-message', 'Cập nhật dữ liệu thành công');
    }
}
