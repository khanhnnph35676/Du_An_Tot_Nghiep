<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric|min:1000|max:100000000',
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            // 'price' => 'required|numeric|min:0',  // giá không âm
            'category_id' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
           'name.required' => 'Tên không được để trống',
            'price.required' => 'Giá không được để trống',
            'price.max' => 'Nhập giá trị nhỏ hơn 99.000.000 VNĐ',
            'price.min' => 'Nhập giá trị phải trên 1.000 VNĐ',
        ];
    }
}
