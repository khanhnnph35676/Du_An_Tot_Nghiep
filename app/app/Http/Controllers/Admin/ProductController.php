<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Gallerie;
use App\Models\Category;
class ProductController extends Controller
{
    // Giao diện
    public function listProducts(){
        $listProducts = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        return view('admin.product.list')->with([
            'listProducts' => $listProducts
        ]);
    }
    public function productDetail(){
        return view('admin.product.detail');
    }
    public function productSimple(){
        $listCategories = Category::get();
        return view('admin.product.simple')->with([
            'listCategories' => $listCategories
        ]);
    }

    public function addProductSimple(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',  // giá không âm
            'category_id' => 'required',  // phải chọn category hợp lệ
        ]);
        $data =[
            'name'=> $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => 'Simple',
            'qty' => $request->qty,
        ];
        $product = Product::create($data);
        if($request->hasFile('image')){
            $image = $request->file('image');
                $nameImage = time() . "_". uniqid() . $image->getClientOriginalExtension();
                $link = "img/prd/";
                $image->move(public_path($link), $nameImage);
                Product::create(['image' => $link.$nameImage]);
        }
        // if($request->hasFile('image')){
        //     $images = $request->file('image');
        //     foreach($images as $key => $image){
        //         $nameImage = time() . "_". uniqid() . $image->getClientOriginalExtension();
        //         $link = "img/prd/";
        //         $image->move(public_path($link), $nameImage);
        //         Gallerie::create([
        //             'product_id' =>  $product->id,
        //             'image' => $link.$nameImage,
        //         ]);
        //     }
        // }
        return redirect()->route('admin.listProducts')->with([
            'message' => 'Thêm mới thành công'
        ]);
    }
    // dữ liệu
    // public function listPostProducts(){

    // }

}
