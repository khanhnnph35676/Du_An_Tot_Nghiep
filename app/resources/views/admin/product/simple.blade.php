@extends('admin.layout.default')
@push('styleHome')
    <link href=" {{ asset('focus-2/focus-2/vendor/summernote/summernote.css') }} " rel="stylesheet">
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Thêm mới sản phẩm</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm mới sản phẩm</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.addProductSimple') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Thêm mới sản phẩm đơn thể</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listProducts') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" type="submit" class="btn btn-secondary">Thêm mới</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        {{-- form thêm cho product --}}
                                        <div class="form-group">
                                            <label for="">Tên sản phẩm: </label>
                                            <input type="number" name="type" value="1" hidden>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Tên sản phẩm">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Số lượng: </label>
                                            <input class="form-control" type="text" name="qty"
                                                placeholder="Số lượng">
                                            @error('qty')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Giá: </label>
                                            <input class="form-control" type="text" name="price" placeholder="Giá">
                                            @error('price')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <div class="form-group">
                                            <label>Danh mục: </label>
                                            <select class="form-control" id="sel1" name="category_id">
                                                @foreach ($listCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Ảnh chính --}}
                                        <div class="form-group">
                                            <label for="">Ảnh chính: </label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            @error('image')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ảnh phụ: </label>
                                            <input type="file" class="form-control" name="gallerie_image[]"
                                                accept="image/*"multiple>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3" style="width: 100%">
                                        <h5>Mô tả sản phẩm: </h5>
                                        <textarea class="summernote" name="description" id="description"></textarea>
                                        {{-- <input type="hidden" name="description" id="description"> --}}
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        window.onload = function() {
            // Tự động ẩn thông báo lỗi sau 1 giây
            var errorElements = document.querySelectorAll('.alert-danger');
            errorElements.forEach(function(errorElement) {
                setTimeout(function() {
                    errorElement.style.display = 'none'; // Ẩn thông báo
                }, 2000); // 1000 milliseconds = 1 second
            });
        };
    </script>
    <script src="{{ asset('backend/js/product.js') }}"></script>
@endsection

@push('scriptHome')
    <script src=" {{ asset('vendor/global/global.min.js') }} "></script>
    <script src=" {{ asset('js/quixnav-init.js') }} "></script>
    <script src=" {{ asset('js/custom.min.js') }} "></script>
    <!-- Summernote -->
    <script src="{{ asset('focus-2/focus-2/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ asset('focus-2/focus-2/js/plugins-init/summernote-init.js') }}"></script>
@endpush
