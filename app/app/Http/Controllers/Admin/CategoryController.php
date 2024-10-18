<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listCategories()
    {
        $categories = Category::all();
        return view('admin.category.list', compact('categories'));
    }
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.list', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'describe' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

        Category::create([
            'name' => $request->name,
            'describe' => $request->describe,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'describe' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Cập nhật tên và mô tả
    $category->name = $request->name;
    $category->describe = $request->describe;

    // Xử lý tải lên ảnh
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu có
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        // Lưu ảnh mới
        $imagePath = $request->file('image')->store('images', 'public');
        $category->image = $imagePath;
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
}


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
