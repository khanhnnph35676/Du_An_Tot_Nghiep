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
        $galleries = Gallerie::get();
        $listProducts = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        return view('admin.product.list')->with([
            'listProducts' => $listProducts,
            'galleries' => $galleries
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

        $product = Product::create($data);
        $id = $product->id;
        if ($request->hasFile('gallerie_image')) {
            $images = $request->file('gallerie_image');
            foreach ($images as $key => $image) {
                $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                $link = "img/prd/";
                $image->move(public_path($link), $nameImage);
                $gallerie = [
                    'product_id' => $id,
                    'image' => $link . $nameImage
                ];
                Gallerie::create($gallerie);
            }
        }
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

        $product->update($data);
        if ($request->hasFile('gallerie_image')) {
            $updateGallerie = Gallerie::where('product_id', $idProduct)->get();
            foreach ($updateGallerie as $value) {
                if ($value->image != null && $value->image != '') {
                    File::delete(public_path($value->image));
                    Gallerie::where('product_id', $idProduct)->delete();
                }
            }
            if ($request->hasFile('gallerie_image')) {
                $images = $request->file('gallerie_image');
                foreach ($images as $key => $image) {
                    $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                    $link = "img/prd/";
                    $image->move(public_path($link), $nameImage);
                    $gallerie = [
                        'product_id' => $idProduct,
                        'image' => $link . $nameImage
                    ];
                    Gallerie::create($gallerie);
                }
            }
        }
        return redirect()->route('admin.listProducts')->with([
            'message' => 'Sửa sản phẩm thành công'
        ]);
    }
    // xoá sản phẩm

    public function deleteProductSimple(Request $request)
    {
        $product = Product::find($request->idProduct);
        $galleries = Gallerie::where('product_id',$request->idProduct)->get();
        foreach($galleries as $gallerie){
            $gallerie->Delete();
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
        if ($request->hasFile('gallerie_image')) {
            $images = $request->file('gallerie_image');
            foreach ($images as $key => $image) {
                $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                $link = "img/prd/";
                $image->move(public_path($link), $nameImage);
                $gallerie = [
                    'product_id' => $id,
                    'image' => $link . $nameImage
                ];
                Gallerie::create($gallerie);
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

        if ($request->hasFile('gallerie_image')) {
            $updateGallerie = Gallerie::where('product_id', $idProduct)->get();
            foreach ($updateGallerie as $value) {
                if ($value->image != null && $value->image != '') {
                    File::delete(public_path($value->image));
                    Gallerie::where('product_id', $idProduct)->delete();
                }
            }
            if ($request->hasFile('gallerie_image')) {
                $images = $request->file('gallerie_image');
                foreach ($images as $key => $image) {
                    $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                    $link = "img/prd/";
                    $image->move(public_path($link), $nameImage);
                    $gallerie = [
                        'product_id' => $idProduct,
                        'image' => $link . $nameImage
                    ];
                    Gallerie::create($gallerie);
                }
            }
        }

        return redirect()->route('admin.listProducts')->with([
            'message' => 'Sửa sản phẩm thành công'
        ]);
    }
    public function restorProduct(){
        $galleries = Gallerie::onlyTrashed()->get();
        $listProducts = Product::with([
            'categories:id,name,image,describe'
        ])->onlyTrashed()->get();
        return view('admin.product.restore')->with([
            'listProducts' => $listProducts,
            'galleries' =>$galleries
        ]);
    }
    public function restoreAction(Request $request)
    {
            $product = Product::withTrashed()->find($request->id);
            if ($product) {
                $product->restore();
                return redirect()->back()->with('success', 'Product restored successfully.');
            }
            return redirect()->back()->with('error', 'Product not found.');
    }
    public function forceDeleteProduct(Request $request)
    {
        $product = Product::withTrashed()->find($request->idProduct);
        $galleries = Gallerie::onlyTrashed()->where('product_id',$request->idProduct)->get();
        $image = $product->image;
        if ($image) {
            File::delete(public_path($image));
        }
        foreach($galleries as $gallerie){
            $gallerie->forceDelete();
        }
        $product->forceDelete();
        return redirect()->back()->with([
            'message' => 'Xoá sản phẩm thành công'
        ]);
    }
}
