<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    // Hiển thị danh sách danh mục blog
    public function list_categories()
    {
        $categories = BlogCategory::paginate(10); // Phân trang danh sách
        return view('admin.blog.categories.list', compact('categories'));
    }

    public function create_category()
    {
        return view('admin.blog.categories.create');
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,blog_categories_name',
        ]);
    
        BlogCategory::create([
            'blog_categories_name' => $request->name, // Đúng với key trong form và database
        ]);
    
        return redirect()->route('admin.blog.categories.list')->with('message', 'Thêm danh mục thành công.');
    }
    

    public function edit_category($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.categories.edit', compact('category'));
    }

    public function update_category(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
            'blog_categories_name' => 'required|string|max:255|unique:blog_categories,blog_categories_name,' . $category->id,
        ]);

        $category->update([
            'blog_categories_name' => $request->blog_categories_name,
        ]);

        return redirect()->route('admin.blog.categories.list')->with('message', 'Cập nhật danh mục thành công.');
    }

    public function destroy_category($id)
    {
        $category = BlogCategory::findOrFail($id);

        // Kiểm tra nếu danh mục có bài viết liên quan
        if ($category->blogs()->count() > 0) {
            return redirect()->route('admin.blog.categories.list')->with('error', 'Không thể xóa danh mục đang chứa bài viết.');
        }

        $category->delete();
        return redirect()->route('admin.blog.categories.list')->with('message', 'Xóa danh mục thành công.');
    }
}
