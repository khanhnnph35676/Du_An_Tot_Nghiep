<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Hiển thị danh sách voucher
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    // Hiển thị form thêm voucher
    public function create()
    {
        return view('admin.vouchers.create');
    }

    // Lưu voucher mới
    public function store(Request $request)
    {
        if (!$request->has('code_vocher')) {
            $request->merge(['code_vocher' => $this->generateUniqueCodeVoucher()]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'sale' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'qty' => 'required|integer|min:0',
            'point' => 'required|integer|min:0',
        ]);

        Voucher::create($request->all());
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher được thêm thành công!');
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
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    // Cập nhật voucher
    public function update(Request $request, $id)
{
    $voucher = Voucher::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'sale' => 'required|numeric|min:0|max:100',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'qty' => 'required|integer|min:0',
        'point' => 'required|integer|min:0',
    ]);

    // Không cần validate 'code_voucher' vì nó được tự động tạo
    $voucher->update($request->all());
    return redirect()->route('admin.vouchers.index')->with('success', 'Voucher được cập nhật thành công!');
}

    // Xóa voucher
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được xóa!');
    }
}
