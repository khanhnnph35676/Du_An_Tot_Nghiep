<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'qty' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'priority' => 'required|integer|min:1',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'discount.required' => 'Giảm giá là bắt buộc.',
            'discount.numeric' => 'Giảm giá phải là một số.',
            'discount.min' => 'Giảm giá phải là số không hoặc lớn hơn.',

            'priority.required' => 'Độ ưu tiên là bắt buộc.',
            'priority.integer' => 'Độ ưu tiên phải là một số nguyên.',
            'priority.min' => 'Độ ưu tiên phải lớn hơn hoặc bằng 1.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.date_format' => 'Ngày bắt đầu phải có định dạng Y-m-d.',

            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.date_format' => 'Ngày kết thúc phải có định dạng Y-m-d.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',

            'qty.required' => 'Số lượng là bắt buộc.',
            'qty.integer' => 'Số lượng  phải là dạng số',
            'qty.min' => 'Số lượng phải lớn hơn 0.',
        ];
    }
}
