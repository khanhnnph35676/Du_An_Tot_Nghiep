<?php

namespace App\Http\Controllers\Admin;
use App\Models\Point;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\OrderList;


class PointController extends Controller
{
    public function index(){
        $listPoints = Point::with('users')->get();
        return view('admin.point.list')->with([
            'listPoints' => $listPoints
        ]);
    }
    public function updatePoint($id){
        $point = Point::with('users')->find($id);
        $listOrders = OrderList::with('orders')->where('user_id',$point->user_id)->get();
        $addresses = Address::where('user_id',$point->user_id)->get();

        return view('admin.point.update')->with([
            'point' => $point,
            'addresses' => $addresses,
            'listOrders' => $listOrders,
        ]);
    }
    public function updatePatchPoint(Request $request){
        $point = Point::where('user_id',$request->user_id )->first();
        $point->update(['point' => $request->point]);
        return redirect()->back()->with('message','Cập nhập điêm mới thành công');
    }

}