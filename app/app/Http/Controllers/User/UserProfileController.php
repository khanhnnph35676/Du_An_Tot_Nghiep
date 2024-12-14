<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderList;
use App\Models\Address;
use App\Models\Voucher;
use App\Models\Point;
use App\Models\UserVoucher;

use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        session()->forget('checkOrder');
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->get();
        $orderLists = OrderList::with('orders', 'orders.address', 'users')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

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

        return view('user.profile', compact('testimonials', 'cart', 'orderLists', 'user', 'address'));
    }
    public function points()
    {
        session()->forget('checkOrder');
        $user = Auth::user();
        $orderLists = OrderList::with('orders', 'orders.address', 'users')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();
        $cart = session()->get('cart', []);
        $listVouchers = Voucher::get();
        $user_voucher = UserVoucher::where('user_id', $user->id)->get();
        $point = Point::where('user_id', $user->id)->first();
        return view('user.point.index', compact('cart', 'orderLists', 'listVouchers', 'point', 'user_voucher'));
    }
    public function addVoucher(Request $request)
    {
        $user = Auth::user();
        $voucher = Voucher::find($request->voucher_id);
        $point = Point::where('user_id', $user->id)->first();

        // Check lỗi hết số lượng và lỗi không đủ điểm
        if ($voucher->qty - 1 < 0) {
            return redirect()->back()->with(['error' => 'Số lượng mã đã hết']);
        }
        if ($point->point - $voucher->point < 0) {
            return redirect()->back()->with(['error' => 'Bạn không đủ điểm để đổi']);
        }

        // Cập nhật số lượng và điểm
        $voucher->update(['qty' => $voucher->qty - 1]);
        $point->update(['point' => $point->point - $voucher->point]);

        // Thêm hoặc cập nhật UserVoucher
        $user_voucher = UserVoucher::where('user_id', $user->id)
            ->where('voucher_id', $request->voucher_id)
            ->first();

        if ($user_voucher == null) {
            UserVoucher::create([
                'voucher_id' => $request->voucher_id,
                'user_id' => $user->id,
                'qty' => 1,
            ]);
        } else {
            $user_voucher->update([
                'qty' => $user_voucher->qty + 1,
            ]);
        }

        return redirect()->back()->with([
            'message' => "Đổi thành công mã: $voucher->code_vocher",
        ]);
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

        // $user->save();

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
