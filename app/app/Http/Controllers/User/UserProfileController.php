<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderList;
use App\Models\Address;
use App\Models\Voucher;
use App\Models\Point;
use App\Models\UserVoucher;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
        $listVouchers = Voucher::whereColumn('start_date', '<', 'end_date')->get();
        $user_voucher = UserVoucher::where('user_id', $user->id)->get();
        $point = Point::where('user_id', $user->id)->first();
        return view('user.point.index', compact('cart', 'orderLists', 'listVouchers', 'point', 'user_voucher'));
    }
    public function addVoucher(Request $request)
    {
        $user = Auth::user();
        $voucher = Voucher::where('id', $request->voucher_id)
                    ->whereColumn('start_date', '<', 'end_date')
                  ->first();
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
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $img = $user->avatar;
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');

            // Lưu đường dẫn file đã lưu
            $img = $path;
        }

        // Validate thông tin cá nhân và địa chỉ
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'nullable|digits:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'phone.digits' => 'Số điện thoại phải có đúng 10 chữ số.',
            'name.required' => 'Tên là bắt buộc.',
            'name.max' => 'Tên không được vượt quá 50 ký tự.',
            'avatar.image' => 'Ảnh đại diện phải là một hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);
        $data= [
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'avatar' => $img,
        ];
        $user->update($data);
        return redirect()->route('user.profile')->with('success', 'Cập nhật thông tin và địa chỉ thành công!');
    }
}
