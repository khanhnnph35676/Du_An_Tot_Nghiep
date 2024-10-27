<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Models\User; // Model người dùng
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function listCustomer()
    {
        $rules = Rule::all();
        $users = User::all();
        return view('admin.customer.list', compact('users', 'rules'));
    }

    // Hiển thị form thêm khách hàng
    public function customerCreate()
    {
        $rules = Rule::all(); // Lấy tất cả các rule từ cơ sở dữ liệu
        return view('admin.customer.create', compact('rules')); // Truyền dữ liệu $rules vào view
    }

    // Lưu thông tin khách hàng mới
    public function customerStore(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email', // Kiểm tra định dạng email hợp lệ
                'unique:users,email', // Kiểm tra email duy nhất trong bảng users
                'max:255', // Giới hạn chiều dài tối đa của email (optional)
            ],
            'phone' => 'nullable|string|max:13',
            'password' => 'required|string|min:6',
            'gender' => 'required|string',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rule_id' => 'required|exists:rules,id', // Kiểm tra rule_id tồn tại trong bảng rules
        ]);

        // Xử lý upload hình ảnh nếu có
        $avatarPath = $request->hasFile('avatar') ? $request->file('avatar')->store('avatars', 'public') : null;

        // Tạo khách hàng mới
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'gender' => $validatedData['gender'],
            'birth_date' => $validatedData['birth_date'],
            'avatar' => $avatarPath,
            'rule_id' => $validatedData['rule_id'],
        ]);

        // Chuyển hướng về trang danh sách khách hàng
        return redirect()->route('admin.listCustomer')->with('message', 'Thêm người dùng thành công');
    }




    // Hiển thị form chỉnh sửa thông tin khách hàng
    public function customerEdit($id)
    {
        $user = User::findOrFail($id);
        $rules = Rule::all(); // Lấy tất cả các rule để hiển thị trong form
        return view('admin.customer.edit', compact('user', 'rules'));
    }

    // Cập nhật thông tin khách hàng
    public function customerUpdate(Request $request, $id)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email', // Kiểm tra định dạng email hợp lệ
                'unique:users,email,' . $id, // Bỏ qua email hiện tại
                'max:255', // Giới hạn chiều dài tối đa của email (optional)
            ],
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rule_id' => 'nullable|exists:rules,id', // Nếu bạn cho phép cập nhật rule_id
        ]);

        // Tìm khách hàng theo ID
        $user = User::findOrFail($id);

        // Cập nhật thông tin người dùng
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'gender' => $validatedData['gender'],
            'birth_date' => $validatedData['birth_date'],
            'rule_id' => $validatedData['rule_id'] ?? $user->rule_id, // Giữ nguyên rule_id nếu không cập nhật
        ]);

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Lưu ảnh mới
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save(); // Lưu lại thông tin
        }

        // Chuyển hướng đến trang chỉnh sửa với ID của khách hàng
        return redirect()->route('admin.listCustomer')->with('message', 'Sửa thông tin người dùng thành công');
    }


    // Xóa khách hàng
    public function customerDestroy($id)
    {
        $user = User::findOrFail($id);

        // Xóa ảnh nếu có
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->back()->with('message', 'Xoá người dùng thành công');
    }
}
