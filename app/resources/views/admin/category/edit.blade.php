@extends('admin.layout.default')

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Cập nhật danh mục</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Cập nhật danh mục</h2>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listCategories') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" class="btn btn-secondary">Cập nhật</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Tên danh mục:</label>
                                    <input class="form-control" type="text" name="name" value="{{ $category->name }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="describe">Mô tả:</label>
                                    <input class="form-control" type="text" name="describe"
                                        value="{{ $category->describe }}">
                                </div>
                                <div class="form-group">
                                    <label for="imageUpload">Ảnh:</label>
                                    <input type="file" class="form-control-file" name="image" accept="image/*">
                                    @if ($category->image)
                                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                            style="max-width: 150px;" class="mt-2">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/js/product.js') }}"></script>
@endsection
