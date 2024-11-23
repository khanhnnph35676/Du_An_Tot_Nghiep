<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        // Dữ liệu cho testimonials
        $cart = session()->get('cart', []);
        $testimonials = [
            (object)[
                'content' => 'Lorem Ipsum is simply dummy text...',
                'image' => 'img/testimonial-1.jpg',
                'client_name' => 'Client Name 1',
                'profession' => 'Profession 1',
                'rating' => 4,
            ],
            (object)[
                'content' => 'Another testimonial content...',
                'image' => 'img/testimonial-2.jpg',
                'client_name' => 'Client Name 2',
                'profession' => 'Profession 2',
                'rating' => 5,
            ],
            // Thêm các testimonial khác...
        ];

        return view('user.profile', compact('testimonials','cart'));
    }
}
