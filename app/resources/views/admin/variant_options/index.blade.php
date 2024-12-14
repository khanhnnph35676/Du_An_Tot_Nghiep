@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/variant.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Xin chào, chào mừng trở lại!</h4>
                    <span class="ml-1">Quản lý biến thể</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Danh sách biến thể</h2>
                        <a href="{{ route('admin.variant-options.index') }}" class="btn btn-dark">
                            <i class="fa fa-trash mr-1"></i>Thùng rác
                        </a>
                    </div>
                    <div class="card-body row">
                        <div class="col-4 ml-3 border">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach($variantOptions as $option)
                                    <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                                        @if($option->image_variant)
                                        <img src="{{ Storage::url($option->image_variant) }}" alt="{{ $option->option_name }}" style="max-width: 50px; height :50px;">
                                        @else
                                        <img src="#" alt="" width="50px" height="50px">
                                        @endif
                                        <h5>{{ $option->option_name }}</h5>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.variant-options.edit', $option->id) }}" class="btn btn-secondary mr-2">Sửa</a>
                                            <form action="{{ route('admin.variant-options.destroy', $option->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?');">
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
                            <h5 class="mt-3">Thêm mới biến thể</h5>
                            <form action="{{ route('admin.variant-options.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="option_name">Tên biến thể:</label>
                                    <input class="form-control" type="text" name="option_name" placeholder="Nhập tên biến thể" required>
                                </div>
                                <div class="form-group">
                                    <label for="option_value">Giá trị biến thể:</label>
                                    <input class="form-control" type="text" name="option_value" placeholder="Nhập giá trị biến thể">
                                </div>
                                <div class="form-group">
                                    <label for="image_variant">Ảnh:</label>
                                    <input type="file" class="form-control-file" name="image_variant" accept="image/*">
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

<script src="{{ asset('backend/js/variant.js') }}"></script>
@endsection