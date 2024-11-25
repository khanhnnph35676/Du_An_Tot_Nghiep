<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function formPayment(){
        $payments = Payment::get();
        return view('admin.payment.form', compact('payments'));
    }

    public function createPayment(){
        $users = User::all();
        $payments = Payment::all();
        return view('admin.payment.create',compact('users', 'payments'));
    }

    public function storePayment(Request $request)
    {
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : '';
        $data = [
            'name' => $request->name,
            'image' => $imagePath
        ];
        Payment::create($data);
        return redirect()->route('admin.formPayment')->with('message', 'Thêm dữ liệu thành công');
    }

    public function updatePayment(Request $request)
    {
        $payment = Payment::find($request->id);
        return view('admin.payment.update', compact('payment'));
    }
    public function update(Request $request)
    {
        $payment = Payment::find($request->id);
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : $payment->image;
        $data =[
            'name' => $request->name,
            'image' => $imagePath
        ];
        $payment->update($data);
        return redirect()->route('admin.formPayment')->with('message', 'Cập nhật dữ liệu thành công');
    }

    public function destroy(Request $request)
    {
        $discount = Payment::find($request->id);
        $discount->delete();
        return redirect()->route('admin.formPayment')->with('message', 'Xóa dữ liệu thành công');
    }
}
