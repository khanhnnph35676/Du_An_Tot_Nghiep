@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Chỉnh sửa danh mục blog</h4>
                    <span class="ml-1">Quản lý danh mục blog</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 d-flex justify-content-end align-items-center">
                <a href="{{ route('admin.blog.categories.list') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left mr-1"></i>Quay lại
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chỉnh sửa danh mục</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.blog.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="blog_categories_name" name="blog_categories_name" placeholder="Nhập tên danh mục" value="{{ old('name', $category->blog_categories_name) }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.blog.categories.list') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/script.js') }}"></script>
@endsection
