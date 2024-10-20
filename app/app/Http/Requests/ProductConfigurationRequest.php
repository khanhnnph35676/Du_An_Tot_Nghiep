<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',  // Sửa lại chỉ 1 rule cho 'name'
            'price' => 'required|numeric|min:1000|max:100000000',
            'category_id' => 'required',
            'variant_sku.*' => 'required|string|max:255',  // Thêm `.*` để áp dụng cho mảng nhiều giá trị
            'variant_stock.*' => 'required|integer|min:0', // Áp dụng cho tất cả các variant_stock
            'variant_price.*' => 'required|numeric|min:1000|max:100000000',
            'option_value.*' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'price.required' => 'Giá không được để trống',
            'price.max' => 'Nhập giá trị nhỏ hơn 99.000.000 VNĐ',
            'price.min' => 'Nhập giá trị phải trên 1.000 VNĐ',
            'variant_sku.*.required' => 'SKU không được để trống',
            'variant_sku.*.max' => 'SKU không được vượt quá 255 ký tự',
            'variant_stock.*.required' => 'Số lượng tồn kho không được để trống',
            'variant_stock.*.integer' => 'Số lượng tồn kho phải là số nguyên',
            'variant_stock.*.min' => 'Số lượng tồn kho không thể âm',
            'variant_price.*.required' => 'Giá không được để trống',  // Thông báo lỗi khi thiếu giá
            'variant_price.*.numeric' => 'Giá phải là số',
            'variant_price.*.min' => 'Giá phải lớn hơn 1.000 VNĐ',
            'variant_price.*.max' => 'Giá phải nhỏ hơn 100.000.000 VNĐ',
            'option_value.*.required' => 'Giá trị tùy chọn không được để trống',
        ];
    }
}
