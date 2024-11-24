<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function listTestimonial()
    {
        // Lấy tất cả testimonials kèm theo thông tin người dùng
        $testimonials = Testimonial::with('user')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }


    // Hiển thị form thêm testimonial
    public function createTestimonial()
    {
        $users = User::all(); // Lấy tất cả người dùng
        return view('admin.testimonials.create', compact('users'));
    }

    // Lưu thông tin testimonial mới
    public function StoreTestimonial(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'star' => 'required|integer|min:1|max:5',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra ảnh
        ]);

        // Xử lý upload hình ảnh nếu có
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('testimonials', 'public') : null;

        // Tạo testimonial mới
        Testimonial::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => $validatedData['user_id'],
            'star' => $validatedData['star'],
            'status' => $validatedData['status'],
            'image' => $imagePath,
        ]);

        // Chuyển hướng về trang danh sách testimonial
        return redirect()->route('admin.listTestimonial')->with('message', 'Thêm testimonial thành công');
    }
    public function editTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $users = User::all(); // Lấy tất cả người dùng
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('admin.testimonials.edit', compact('testimonial', 'users', 'products'));
    }


    // Cập nhật testimonial
    public function updateTestimonial(Request $request, $id)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id', // Kiểm tra sản phẩm
            'star' => 'required|integer|min:1|max:5',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra ảnh
        ]);

        // Tìm testimonial theo ID
        $testimonial = Testimonial::findOrFail($id);

        // Cập nhật thông tin testimonial
        $testimonial->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => $validatedData['user_id'],
            'product_id' => $validatedData['product_id'],
            'star' => $validatedData['star'],
            'status' => $validatedData['status'],
        ]);
        // Nếu có thay đổi ảnh, xử lý
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($testimonial->product && $testimonial->product->image) {
                Storage::disk('public')->delete($testimonial->product->image); // Xóa ảnh cũ của sản phẩm
            }

            // Lưu ảnh mới
            $testimonial->image = $request->file('image')->store('testimonials', 'public');
            $testimonial->save(); // Lưu lại thông tin
        }

        // Chuyển hướng về danh sách testimonials
        return redirect()->route('admin.listTestimonial')->with('message', 'Sửa testimonial thành công');
    }


    // Xóa testimonial
    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();

        return redirect()->route('admin.listTestimonial')->with('message', 'Xoá testimonial thành công');
    }
}
