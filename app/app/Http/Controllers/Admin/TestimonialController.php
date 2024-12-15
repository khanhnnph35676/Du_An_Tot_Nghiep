<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Gallerie;
use App\Models\ProductVariant;
use App\Models\MessOrder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function getProductTestimonials($id)
    {
        $messages = MessOrder::with('user', 'order')->get();
        $testimonials = Testimonial::with('user')
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
            ->get();

        return view('user.product.testimonials', compact('testimonials','messages'));
    }

    public function listTestimonial()
    {
        // Lấy tất cả testimonials kèm theo thông tin người dùng
        $messages = MessOrder::with('user', 'order')->get();
        $testimonials = Testimonial::with('user', 'product')->get();
        // dd($testimonials);
        return view('admin.testimonials.index', compact('testimonials','messages'));
    }

    // Hiển thị form thêm testimonial
    public function createTestimonial()
    {
        $galleries = Gallerie::get();
        $variants = ProductVariant::get();
        $products = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        $messages = MessOrder::with('user', 'order')->get();
        $users = User::where('rule_id', 2)->get();
        return view('admin.testimonials.create', compact('users', 'variants', 'galleries', 'products','messages'));
    }

    // Lưu thông tin testimonial mới
    public function StoreTestimonial(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required'
        ], [
            'product_id.required' => 'Vui lòng chọn ít nhất một sản phẩm.',
            'product_id.array' => 'Danh sách sản phẩm phải là một mảng.',
            'product_id.*.exists' => 'Sản phẩm được chọn không tồn tại.',
            'rating.required' => 'Vui lòng chọn đánh giá.',
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá tối thiểu là :min sao.',
            'rating.max' => 'Đánh giá tối đa là :max sao.',
            'content.required' => 'Nội dung chưa nhập',
        ]);

        // Validate dữ liệu
        $request->validate([
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id', // Mỗi phần tử trong mảng phải tồn tại trong bảng `products`
            'rating' => 'required',
        ]);
        if (is_array($request->product_id)) {
            foreach ($request->product_id as $value) {
                $data = [
                    'product_id' => $value,
                    'user_id' => $request->user_id,
                    'rating' => $request->rating,
                    'content' => $request->content
                ];
                Testimonial::create($data);
            }
        }
        return redirect()->route('admin.testimonials')->with('message', 'Thêm đánh giá thành công');
    }
    public function editTestimonial($id)
    {
        $testimonial = Testimonial::with('user', 'product')->find($id);
        $users = User::where('rule_id', 2)->get();
        $messages = MessOrder::with('user', 'order')->get();
        return view('admin.testimonials.edit', compact('testimonial', 'users','messages'));
    }

    // Cập nhật testimonial
    public function updateTestimonial(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required'
        ], [
            'rating.required' => 'Vui lòng chọn đánh giá.',
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.min' => 'Đánh giá tối thiểu là :min sao.',
            'rating.max' => 'Đánh giá tối đa là :max sao.',
            'content.required' => 'Nội dung chưa nhập',
        ]);
        // Tìm testimonial theo ID
        $testimonial = Testimonial::with('user', 'product')->find($request->id);

        $testimonial->update([
            'content' => $request->content,
            'rating' => $request->rating,
            'user_id' => $request->user_id,
        ]);

        return redirect()->back()->with('message', 'Sửa đánh giá thành công');
    }

    // Xóa testimonial
    public function deleteTestimonial(Request $request)
    {
        $testimonial = Testimonial::find($request->id);
        $testimonial->delete();
        return redirect()->route('admin.testimonials')->with('message', 'Xoá đánh giá thành công');
    }
}
