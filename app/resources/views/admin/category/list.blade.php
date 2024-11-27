@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Xin chào, chào mừng trở lại!</h4>
                    <span class="ml-1">Quản lý danh mục</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Danh sách danh mục</h2>
                        <a href="{{ route('admin.categories.deleted') }}" class="btn btn-dark">  <i class="fa fa-trash mr-1"></i>Thùng rác</a>

                    </div>
                    <div class="card-body row">
                        <div class="col-4 ml-3 border">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach($categories as $category)
                                    <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                                        @if($category->image)
                                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="max-width: 50px; height :50px;">
                                        @else

                                        <img src="#" alt="" width="50px" height="50px">
                                        @endif
                                        <h5>{{ $category->name }}</h5>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-secondary mr-2">Sửa</a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-dark">Xoá</button>
                                            </form>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-7 border ml-3">
                            <h5 class="mt-3">Thêm mới danh mục</h5>
                            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên danh mục:</label>
                                    <input class="form-control" type="text" name="name" placeholder="Nhập tên danh mục" required>
                                </div>
                                <div class="form-group">
                                    <label for="describe">Mô tả:</label>
                                    <input class="form-control" type="text" name="describe" placeholder="Mô tả">
                                </div>
                                <div class="form-group">
                                    <label for="imageUpload">Ảnh:</label>
                                    <input type="file" class="form-control-file" name="image" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-secondary mb-3">Thêm mới</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/product.js') }}"></script>
@endsection
