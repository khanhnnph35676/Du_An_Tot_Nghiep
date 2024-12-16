<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\MessOrder;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->listCategories();
    }
    public function listCategories()
    {
        // Lấy tất cả các category chưa bị xóa
        $categories = Category::whereNull('deleted_at')->get();
        $messages = MessOrder::with('user','order')->get();
        return view('admin.category.list', compact('categories','messages'));
    }
    public function editCategory($id){
        $category = Category::find($id);
        $messages = MessOrder::with('user','order')->get();
        return view('admin.category.edit', compact('category','messages'));
    }
    public function pathchEditCategory(Request $request, $id){
        $categorie = Category::find($id);
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : $categorie->image;
        $category=[
            'name' => $request->name,
            'describe' => $request->describe,
            'image' => $imagePath
        ];
        $categorie->update($category);
        return redirect()->route('admin.categories.index')->with('success', 'Sửa danh mục thành công');
    }
    public function listDeletedCategories()
    {
        // Lấy tất cả các category đã bị xóa (xóa mềm)
        $deletedCategories = Category::onlyTrashed()->get();
        $messages = MessOrder::with('user','order')->get();
        return view('admin.category.deleted', compact('deletedCategories','messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'describe' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý upload ảnh
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

        Category::create([
            'name' => $request->name,
            'describe' => $request->describe,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thánh công');
    }

    public function destroy(Category $category)
    {
        $category->delete();  // Xóa mềm
        return redirect()->route('admin.categories.index')->with('success', 'Xoá thành công');
    }

    public function restore($id)
    {
        // Khôi phục lại category đã bị xóa mềm
        $category = Category::onlyTrashed()->find($id);
        if ($category) {
            $category->restore();
            return redirect()->route('admin.categories.deleted')
                             ->with('success', 'Khôi phục thành công!');
        }

        return redirect()->route('admin.categories.deleted')->with('error', 'Lỗi khôi phục');
    }

    public function forceDestroy($id)
    {
        // Xóa vĩnh viễn category
        $category = Category::onlyTrashed()->find($id);
        if ($category) {
            $category->forceDelete();
            return redirect()->route('admin.categories.deleted')->with('success', 'Xoá thành công.');
        }

        return redirect()->route('admin.categories.deleted')->with('error', 'Category not found.');
    }


}
