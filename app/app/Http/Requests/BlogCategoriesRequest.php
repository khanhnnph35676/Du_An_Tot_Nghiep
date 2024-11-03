<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoriesRequest extends FormRequest
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
            'blog_categories_name' => 'required|unique:blog_categories,blog_categories_name',
        ];
    }
    public function messages(): array
    {
        return [
            'blog_categories_name.required' => 'Tên danh mục Blog không được để trống',
            'blog_categories_name.unique' => 'Tên danh mục Blog đã tồn tại.',
        ];
    }
}
