<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'status' => 'string',
            'blog_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'list_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'short_content' => 'required|string|max:500',
            'author' => 'required|string|max:100',
            'full_content' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
        ];
    }

    public function messages()
    {
        return [
            
            'blog_image.required' => 'Ảnh chính không được để trống.',
            'blog_image.image' => 'Ảnh chính phải là một hình ảnh.',
            'blog_image.mimes' => 'Ảnh chính phải có định dạng jpeg, png, jpg, gif.',
            'blog_image.max' => 'Ảnh chính không được quá 2MB.',
            'list_image.*.image' => 'Danh sách ảnh phải là hình ảnh.',
            'list_image.*.mimes' => 'Danh sách ảnh phải có định dạng jpeg, png, jpg, gif.',
            'list_image.*.max' => 'Mỗi ảnh trong danh sách không được quá 2MB.',
            'title.required' => 'Tiêu đề không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'short_content.required' => 'Nội dung ngắn không được để trống.',
            'short_content.max' => 'Nội dung ngắn không được vượt quá 500 ký tự.',
            'author.required' => 'Tác giả không được để trống.',
            'author.max' => 'Tác giả không được vượt quá 100 ký tự.',
            'full_content.required' => 'Nội dung đầy đủ không được để trống.',
            'category_id.required' => 'Danh mục không được để trống.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
        ];
    }

}
