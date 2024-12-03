<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'BlogTitle' => 'required|max:255',
            'Status' => 'required|in:0,1', // Giả sử 0: không hiển thị, 1: hiển thị
            'BlogSlug' => 'required',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            // BlogTitle
            'BlogTitle.required' => 'Tiêu đề bài viết không được để trống.',
            'BlogTitle.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự.',
            // Status
            'Status.required' => 'Trạng thái bài viết không được để trống.',
            'Status.in' => 'Trạng thái bài viết chỉ được chọn là 0 (ẩn) hoặc 1 (hiện).',
            // BlogSlug
            'BlogSlug.required' => 'Slug bài viết không được để trống.',
        ];
    }

}
