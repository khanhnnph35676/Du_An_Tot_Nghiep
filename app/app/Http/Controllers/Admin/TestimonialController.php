<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        // Giả định rằng bạn có một model Testimonial
        $testimonials = []; // Thay thế bằng logic lấy dữ liệu từ model

        return view('admin.testimonial.list', compact('testimonials'));
    }
}
