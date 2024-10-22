<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Gallerie;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\VariantOption;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductAdminRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductConfigurationRequest;

class ProductController extends Controller
{
    // Giao diện
    public function listProducts()
    {
        $listProducts = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        return view('admin.product.list')->with([
            'listProducts' => $listProducts
        ]);
    }
    // chi tiết sản phẩm có biến thể
    public function productDetail()
    {
        $variants = VariantOption::select('option_name')->distinct()->get();
        $categories = Category::all();
        $variant_values = VariantOption::get();
        return view('admin.product.detail')->with([
            'categories' => $categories,
            'variants' => $variants,
            'variant_values' => $variant_values
        ]);
    }
    // chi tiết sản phẩm đơn thể
    public function productSimple()
    {
        $listCategories = Category::get();
        return view('admin.product.simple')->with([
            'listCategories' => $listCategories
        ]);
    }
    // thêm sản phẩm
    public function addProductSimple(ProductAdminRequest $request)
    {
        $image_url = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = time() . "_" . uniqid() . $image->getClientOriginalExtension();
            $link = "img/prd/";
            $image->move(public_path($link), $nameImage);
            $image_url = $link . $nameImage;
        }
        $data = [
            'name' => $request->name,
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
    public function formUpdateProductSimple($type, $idProduct)
    {
        $product = Product::find($idProduct);
        $listCategories = Category::get();
        return view('admin.product.update-simple')->with([
            'listCategories' => $listCategories,
            'product' => $product
        ]);
    }
    // update sản phẩm
    public function updateProductSimple($idProduct, ProductAdminRequest $request)
    {
        $product = Product::find($idProduct);
        $image_url = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
            $link = "img/prd/";
            $image->move(public_path($link), $nameImage);
            $image_url = $link . $nameImage;
        }

        $data = [
            'name' => $request->name,
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

    public function deleteProductSimple(Request $request)
    {
        $product = Product::find($request->idProduct);
        $image = $product->image;
        if ($image) {
            File::delete(public_path($image));
        }
        $product->delete();
        return redirect()->back()->with([
            'message' => 'Xoá sản phẩm thành công'
        ]);
    }
    // thêm sản phẩm có biến thể
    public function addProductConfigurable(ProductConfigurationRequest $request)
    {
        $image_url = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = time() . "_" . uniqid() . "." . $image->getClientOriginalExtension(); // Sửa lại để thêm dấu chấm
            $link = "img/prd/";
            $image->move(public_path($link), $nameImage);
            $image_url = $link . $nameImage;
        }

        // Tạo sản phẩm chính (configurable product)
        $product = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => '2', // type 2 là sản phẩm có biến thể
            'qty' => '0',
            'image' => $image_url
        ];
        $product = Product::create($product);
        $id = $product->id;
        if (is_array($request->option_value)) {
            foreach ($request->option_value as $key => $optionValue) {
                $option_value = VariantOption::where('option_value', $optionValue)->get();
                foreach ($option_value as $value) {
                    $productVariant = [
                        'product_id' => $id,
                        'price' => $request->variant_price[$key],
                        'sku' => $request->variant_sku[$key],
                        'stock' => $request->variant_stock[$key],
                        'option_value' => $value->id,
                        // 'image' => $variantImageUrl // Đường dẫn ảnh biến thể
                    ];
                    ProductVariant::create($productVariant);
                }
                // $variantImageUrl = null;
                // if ($request->hasFile("variant_image.$key")) {
                //     $variantImage = $request->file("variant_image.$key");
                //     $variantImageName = time() . "_" . uniqid() . "." . $variantImage->getClientOriginalExtension();
                //     $variantImage->move(public_path($link), $variantImageName);
                //     $variantImageUrl = $link . $variantImageName;
                // }

            }
        }
        return redirect()->route('admin.listProducts')->with([
            'message' => 'Thêm mới sản phẩm biến thể thành công',
        ]);
    }
    public function formUpdateProductConfigurable($type, $idProduct)
    {
        $variants = VariantOption::select('option_name')->distinct()->get();
        $categories = Category::get();
        $variant_values = VariantOption::get();
        $product = Product::find($idProduct);
        $productVariants = ProductVariant::where('product_id', $product->id)->get();
        return view('admin.product.update-detail')->with([
            'categories' => $categories,
            'product' => $product,
            'variants' => $variants,
            'variant_values' => $variant_values,
            'productVariants' => $productVariants
        ]);
    }
    public function updateProductConfigurable($idProduct, ProductAdminRequest $request)
    {
        $product = Product::find($idProduct);
        $image_url = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
            $link = "img/prd/";
            $image->move(public_path($link), $nameImage);
            $image_url = $link . $nameImage;
        }

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'qty' => $request->qty,
            'image' => $image_url,
            'type' => '2'
        ];
        $product->update($data);
        $product_variants = ProductVariant::where("product_id", $idProduct)->get();

        foreach ($product_variants as $key => $value) {
            $productVariant = ProductVariant::find($value->id);
            if ($productVariant) {
                $productVariant->price = $request->variant_price[$key];
                $productVariant->sku = $request->variant_sku[$key];
                $productVariant->stock = $request->variant_stock[$key];
                $productVariant->save();
            }
        }

        return redirect()->route('admin.listProducts')->with([
            'message' => 'Sửa sản phẩm thành công'
        ]);
    }
}
