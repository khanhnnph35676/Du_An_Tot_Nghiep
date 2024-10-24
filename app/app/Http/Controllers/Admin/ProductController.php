<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Gallerie;
use App\Models\Category;
use App\Http\Requests\ProductAdminRequest;
use Illuminate\Support\Facades\File;
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
    // chi tiết sản phẩm có biến thể
    public function productDetail(){
        $categories = Category::all();
        return view('admin.product.detail');
    }
    // chi tiết sản phẩm đơn thể
    public function productSimple(){
        $listCategories = Category::get();
        return view('admin.product.simple')->with([
            'listCategories' => $listCategories
        ]);
    }
    // thêm sản phẩm
    public function addProductSimple(ProductAdminRequest $request){
        $image_url = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = time() . "_". uniqid() . $image->getClientOriginalExtension();
            $link = "img/prd/";
            $image->move(public_path($link), $nameImage);
            $image_url = $link.$nameImage;
        }
        $data =[
            'name'=> $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'qty' => $request->qty,
            'image' => $image_url
        ];

        Product::create($data);
        return redirect()->route('admin.listProducts')->with([
            'message' => 'Thêm mới thành công'
        ]);
    }
    // form update sản phẩm đơn thể
    public function formUpdateProductSimple($type,$idProduct){
        $product = Product::find($idProduct);
        $listCategories = Category::get();
        return view('admin.product.update-simple')->with([
            'listCategories' => $listCategories,
            'product' => $product
        ]);
    }
    // update sản phẩm
    public function updateProductSimple($idProduct,ProductAdminRequest $request){
        $product = Product::find($idProduct);
        $image_url = $product->image;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = time() . "_". uniqid() . '.' . $image->getClientOriginalExtension();
            $link = "img/prd/";
            $image->move(public_path($link), $nameImage);
            $image_url = $link.$nameImage;
        }

        $data =[
            'name'=> $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'qty' => $request->qty,
            'image' => $image_url
        ];
         // Kiểm tra nếu có file upload từ CKEditor

        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $path = $file->storeAs('media', $filename, 'public');

        //     // Chèn hình ảnh vào mô tả với một thẻ <img>
        //     $imgTag = '<img src="' . url('storage/' . $path) . '" alt="' . $filename . '" style="max-width: 100%; height: auto;">';

        //     // Thêm thẻ <img> vào mô tả nhưng chỉ lưu một thẻ ngắn gọn
        //     $data['description'] .= $imgTag;
        // }

        $product->update($data);
        return redirect()->route('admin.listProducts')->with([
            'message' => 'Sửa sản phẩm thành công'
        ]);
    }
    // xoá sản phẩm

     public function deleteProductSimple(Request $request){
        $product = Product::find($request->idProduct);
        $image = $product->image;
        if ($image) {
            File::delete(public_path($image));
        }
        $product->delete();
        return redirect()->back()->with([
            'message'=>'Xoá sản phẩm thành công'
        ]);
    }
}