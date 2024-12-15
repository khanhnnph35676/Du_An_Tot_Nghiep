<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\MessOrder;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function formPayment(){
        $messages = MessOrder::with('user','order')->get();
        $payments = Payment::get();
        return view('admin.payment.form', compact('payments','messages'));
    }

    public function createPayment(){
        $users = User::all();
        $payments = Payment::all();
        $messages = MessOrder::with('user','order')->get();
        return view('admin.payment.create',compact('users', 'payments','messages'));
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
        $messages = MessOrder::with('user','order')->get();
        return view('admin.payment.update', compact('payment','messages'));
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
