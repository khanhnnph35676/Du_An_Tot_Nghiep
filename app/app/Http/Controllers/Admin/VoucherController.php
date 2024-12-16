<?php

namespace App\Http\Controllers\Admin;
use App\Models\MessOrder;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Hiển thị danh sách voucher
    public function index()
    {
        $messages = MessOrder::with('user','order')->get();
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers','messages'));
    }

    // Hiển thị form thêm voucher
    public function create()
    {
        $messages = MessOrder::with('user','order')->get();
        return view('admin.vouchers.create',compact('messages'));
    }

    // Lưu voucher mới
    public function store(Request $request)
{
    if (!$request->has('code_vocher')) {
        $request->merge(['code_vocher' => $this->generateUniqueCodeVoucher()]);
    }

    $messages = MessOrder::with('user','order')->get();
    $request->validate([
        'name' => 'required|string|max:255',
        'sale' => 'required|numeric|min:0|max:100',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'qty' => 'required|integer|min:0',
        'point' => 'required|integer|min:0',
        'money' => 'required|numeric|min:0', // Thêm điều kiện cho money
    ]);

    Voucher::create($request->all());
    return redirect()->route('admin.vouchers.index', compact('messages'))->with('success', 'Voucher được thêm thành công!');
}

public function update(Request $request, $id)
{
    $voucher = Voucher::findOrFail($id);
    $messages = MessOrder::with('user','order')->get();

    $request->validate([
        'name' => 'required|string|max:255',
        'sale' => 'required|numeric|min:0|max:100',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'qty' => 'required|integer|min:0',
        'point' => 'required|integer|min:0',
        'money' => 'required|numeric|min:0', // Thêm điều kiện cho money
    ]);

    $voucher->update($request->all());
    return redirect()->route('admin.vouchers.index', compact('messages'))->with('success', 'Voucher được cập nhật thành công!');
}

    private function generateUniqueCodeVoucher()
    {
        do {
            $code = Str::upper(Str::random(8));
        } while (Voucher::where('code_vocher', $code)->exists());

        return $code;
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $messages = MessOrder::with('user','order')->get();
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher','messages'));
    }

    // Cập nhật voucher
   
    // Xóa voucher
    public function destroy($id)
    {
        $messages = MessOrder::with('user','order')->get();
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index',compact('messages'))->with('success', 'Voucher đã được xóa!');
    }
}
