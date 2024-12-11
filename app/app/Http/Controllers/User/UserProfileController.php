<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderList;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->get();
        $orderLists = OrderList::with('orders','orders.address' ,'users')->get();

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

        return view('user.profile', compact('testimonials','cart','orderLists','user','address'));
    }
    public function points(){
        $orderLists = OrderList::with('orders','orders.address' ,'users')->get();
        $cart = session()->get('cart', []);
        return view('user.point.index', compact('cart','orderLists'));
    }
    public function update(Request $request)
{
    $user = Auth::user();

    // Validate thông tin cá nhân và địa chỉ
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|digits_between:10,15',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gender' => 'nullable|in:male,female,other',
        'address' => 'required|string|max:255',
        'home_address' => 'nullable|string|max:255',
    ]);

    // Cập nhật thông tin người dùng
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');
    $user->gender = $request->input('gender');

    // Cập nhật avatar nếu có
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $avatarPath;
    }

    $user->save();

    // Cập nhật địa chỉ
    $address = Address::where('user_id', $user->id)->first();
    if ($address) {
        $address->update([
            'address' => $request->input('address'),
            'home_address' => $request->input('home_address'),
        ]);
    } else {
        Address::create([
            'user_id' => $user->id,
            'address' => $request->input('address'),
            'home_address' => $request->input('home_address'),
        ]);
    }

    return redirect()->route('user.profile')->with('success', 'Cập nhật thông tin và địa chỉ thành công!');
}

}
