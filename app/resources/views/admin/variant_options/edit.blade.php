@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/variant.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Xin chào, chào mừng trở lại!</h4>
                    <span class="ml-1">Sửa biến thể</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Chỉnh sửa biến thể</h2>
                        <a href="{{ route('admin.variant-options.index') }}" class="btn btn-dark">
                            <i class="fa fa-arrow-left mr-1"></i>Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.variant-options.update', $variantOption->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="option_name">Tên biến thể:</label>
                                <input class="form-control" type="text" name="option_name" value="{{ old('option_name', $variantOption->option_name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="option_value">Giá trị biến thể:</label>
                                <input class="form-control" type="text" name="option_value" value="{{ old('option_value', $variantOption->option_value) }}">
                            </div>

                            <div class="form-group">
                                <label for="image_variant">Ảnh:</label>
                                <input type="file" class="form-control-file" name="image_variant" accept="image/*">
                                @if($variantOption->image_variant)
                                    <img src="{{ Storage::url($variantOption->image_variant) }}" alt="{{ $variantOption->option_name }}" style="max-width: 100px; height: 100px;">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-secondary mb-3">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/variant.js') }}"></script>
@endsection
