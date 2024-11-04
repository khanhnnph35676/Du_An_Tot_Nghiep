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
        $variants = ProductVariant::get();
        $listProducts = Product::with([
            'categories:id,name,image,describe'
        ])->get();
        return view('admin.product.list')->with([
            'listProducts' => $listProducts,
            'galleries' => $galleries,
            'variants' => $variants,
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
            if (!empty($image_url) && File::exists(public_path($image_url))) {
                File::delete(public_path($image_url)); // Xóa ảnh cũ
            }
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
        $galleries = Gallerie::where('product_id', $request->idProduct)->get();
        $variants = ProductVariant::where('product_id', $request->idProduct)->get();
        foreach ($variants as $variant) {
            $variant->Delete();
        }
        foreach ($galleries as $gallerie) {
            $gallerie->Delete();
        }
        $product->delete();
        return redirect()->back()->with([
            'message' => 'Xoá sản phẩm thành công'
        ]);
    }
    public function deleteVariant(Request $request)
    {
        $variant = ProductVariant::find($request->idProduct);
        $variant->Delete();

        return redirect()->back()->with([
            'message' => 'Xoá sản phẩm biến thể thành công'
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
        // ảnh phụ của sản phẩm
        if ($request->hasFile('gallerie_image')) {
            $images = $request->file('gallerie_image');
            foreach ($images as $key => $image) {
                $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                $link = "img/prd/gallerie_image";
                $image->move(public_path($link), $nameImage);
                $gallerie = [
                    'product_id' => $id,
                    'image' => $link . $nameImage
                ];
                Gallerie::create($gallerie);
            }
        }
        if (is_array($request->option_value)) {
            foreach ($request->option_value as $key => $optionValue) {
                $option_values = VariantOption::where('option_value', $optionValue)->get();

                foreach ($option_values as $value) {
                    $imagePath = null;
                    if ($request->hasFile("variant_image.$key")) {
                        $image = $request->file("variant_image.$key");
                        $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                        $link = "img/prd/variant_image";
                        $image->move(public_path($link), $nameImage);
                        $imagePath = $link . '/' . $nameImage;
                    }

                    $productVariant = [
                        'product_id' => $id,
                        'price' => $request->variant_price[$key],
                        'sku' => $request->variant_sku[$key],
                        'stock' => $request->variant_stock[$key],
                        'option_value' => $value->id,
                        'image' => $imagePath
                    ];

                    ProductVariant::create($productVariant);
                }
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
            if (!empty($image_url) && File::exists(public_path($image_url))) {
                File::delete(public_path($image_url)); // Xóa ảnh cũ
            }
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
            if ($request->hasFile("variant_image.$key")) {
                if (!empty($value->image) && File::exists(public_path($value->image))) {
                    File::delete(public_path($value->image)); // Xóa ảnh cũ
                }
                $image = $request->file("variant_image.$key");
                $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                $link = "img/prd/variant_image";
                $image->move(public_path($link), $nameImage);
                $value->image = $link . '/' . $nameImage;
            }
            $value->price = $request->variant_price[$key];
            $value->sku = $request->variant_sku[$key];
            $value->stock = $request->variant_stock[$key];
            $value->save();
        }

        if (!is_array($product_variants)) {
            if (is_array($request->option_value)) {
                foreach ($request->option_value as $key => $optionValue) {
                    $option_values = VariantOption::where('option_value', $optionValue)->get();

                    foreach ($option_values as $value) {
                        $imagePath = null;
                        if ($request->hasFile("variant_image.$key")) {
                            $image = $request->file("variant_image.$key");
                            $nameImage = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                            $link = "img/prd/variant_image";
                            $image->move(public_path($link), $nameImage);
                            $imagePath = $link . '/' . $nameImage;
                        }

                        $productVariant = [
                            'product_id' => $idProduct,
                            'price' => $request->variant_price[$key],
                            'sku' => $request->variant_sku[$key],
                            'stock' => $request->variant_stock[$key],
                            'option_value' => $value->id,
                            'image' => $imagePath
                        ];

                        ProductVariant::create($productVariant);
                    }
                }
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
    public function restorProduct()
    {
        $galleries = Gallerie::onlyTrashed()->get();
        $variants = ProductVariant::onlyTrashed()->get();
        $listProducts = Product::with([
            'categories:id,name,image,describe'
        ])->onlyTrashed()->get();
        return view('admin.product.restore')->with([
            'listProducts' => $listProducts,
            'galleries' => $galleries,
            'variants' => $variants
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
        $galleries = Gallerie::onlyTrashed()->where('product_id', $request->idProduct)->get();
        $image = $product->image;
        if (!empty($image)) {
            File::delete(public_path($image));
        }
        foreach ($galleries as $gallerie) {
            $gallerie->forceDelete();
        }
        $product->forceDelete();
        return redirect()->back()->with([
            'message' => 'Xoá sản phẩm thành công'
        ]);
    }
    public function forceDeleteVariant(Request $request)
    {
        $variant = ProductVariant::withTrashed()->find($request->idProduct);
        if (!empty($variant->image)) {
            $image = $variant->image;
            File::delete(public_path($image));
        }
        $variant->forceDelete();
        return redirect()->back()->with([
            'message' => 'Xoá sản phẩm thành công'
        ]);
    }
    public function restoreVariantAction(Request $request)
    {
        $variant = ProductVariant::withTrashed()->find($request->id);
        if ($variant) {
            $variant->restore();
            return redirect()->back()->with('success', 'Product variant restored successfully.');
        }
        return redirect()->back()->with('error', 'Product not found.');
    }
}
