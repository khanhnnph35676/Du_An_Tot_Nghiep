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
    public function rules()
    {
        return [
            'BlogTitle' => 'required|string|max:255',
            'BlogContent' => 'required|string',
            'Status' => 'required|in:0,1', // Giả sử 0: không hiển thị, 1: hiển thị
            'BlogDesc' => 'required|string|max:500',
            'BlogSlug' => 'required|string|max:255|unique:blogs,BlogSlug',
            'BlogImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Chỉ chấp nhận file ảnh tối đa 2MB
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages()
    {
        return [
            // BlogTitle
            'BlogTitle.required' => 'Tiêu đề bài viết không được để trống.',
            'BlogTitle.string' => 'Tiêu đề bài viết phải là chuỗi ký tự.',
            'BlogTitle.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự.',

            // BlogContent
            'BlogContent.required' => 'Nội dung bài viết không được để trống.',
            'BlogContent.string' => 'Nội dung bài viết phải là chuỗi ký tự.',

            // Status
            'Status.required' => 'Trạng thái bài viết không được để trống.',
            'Status.in' => 'Trạng thái bài viết chỉ được chọn là 0 (ẩn) hoặc 1 (hiện).',

            // BlogDesc
            'BlogDesc.required' => 'Mô tả bài viết không được để trống.',
            'BlogDesc.string' => 'Mô tả bài viết phải là chuỗi ký tự.',
            'BlogDesc.max' => 'Mô tả bài viết không được vượt quá 500 ký tự.',

            // BlogSlug
            'BlogSlug.required' => 'Slug bài viết không được để trống.',
            'BlogSlug.string' => 'Slug bài viết phải là chuỗi ký tự.',
            'BlogSlug.max' => 'Slug bài viết không được vượt quá 255 ký tự.',
            'BlogSlug.unique' => 'Slug bài viết đã tồn tại, hãy chọn slug khác.',

            // BlogImage
            'BlogImage.required' => 'Hình ảnh bài viết không được để trống.',
            'BlogImage.image' => 'Hình ảnh bài viết phải là file định dạng jpeg, png, jpg hoặc gif.',
            'BlogImage.mimes' => 'Hình ảnh bài viết phải có định dạng jpeg, png, jpg hoặc gif.',
            'BlogImage.max' => 'Dung lượng hình ảnh bài viết không được vượt quá 2MB.',
        ];
    }

}
