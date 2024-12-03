@extends('admin.layout.default')
@push('styleHome')
    <link href=" {{ asset('focus-2/focus-2/vendor/summernote/summernote.css') }} " rel="stylesheet">
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
    <style>
        .cke_notification {
            display: none !important;
        }
    </style>
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
                    <form action="{{ route('admin.addProductConfigurable') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Thêm mới sản phẩm có biến thể</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listProducts') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" type="submit" class="btn btn-secondary">Thêm mới</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        {{-- form thêm cho product --}}
                                        {{-- <input class="form-control" type="text" placeholder="Name" name="id" hidden> --}}
                                        <div class="form-group">
                                            <label for="">Tên sản phẩm:</label>
                                            <input class="form-control" type="text" placeholder="Tên sản phẩm"
                                                name="name">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Số lượng:</label>
                                            <input class="form-control" type="text" name='qty' placeholder="Số lượng"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Giá:</label>
                                            <input class="form-control" type="text" name="price" placeholder="Giá">
                                            @error('price')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Biến thể:</label>
                                            <div class="form-check form-check-inline">
                                                @foreach ($variants as $value)
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input variant-checkbox"
                                                            name="option_name"
                                                            value="{{ $value->option_name }}">{{ $value->option_name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group ml-4">
                                            <div id="selected-variant"></div>
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <div class="form-group">
                                            <label>Danh mục:</label>
                                            <select class="form-control" id="sel1" name='category_id'>
                                                @foreach ($categories as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ảnh chính: </label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ảnh phụ: </label>
                                            <input type="file" class="form-control" name="gallerie_image[]"
                                                accept="image/*"multiple>
                                        </div>
                                    </div>
                                    {{-- phần biến thể phải làm bằng front-end
                                        1,nếu click chọn loại thì in ra danh sách loại
                                        2,Chọn loại 2 cái nó sẽ in ra 2 bản ghi để thêm product varian  --}}
                                    <div class="card-body border mt-3">
                                        <h5>Danh sách sản phẩm</h5>
                                        <div class="table-responsive">
                                            <table id="example" class="display">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Ảnh sản phẩm</th>
                                                        <th>Tên biến thể</th>
                                                        <th>Tồn kho</th>
                                                        <th>GIá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                @error('variant_sku')
                                                    <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('variant_stock')
                                                    <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('variant_price')
                                                    <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('option_value')
                                                    <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                    </div>
                                                @enderror

                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3" style="width: 100%">
                                        <h5>Mô tả sản phẩm: </h5>
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                        <script>
                                            $(document).ready(function() {
                                                CKEDITOR.replace('description');
                                            });
                                        </script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        var variants = @json($variant_values);

        $(document).ready(function() {
            // Khi thay đổi lựa chọn checkbox cho biến thể
            $('.variant-checkbox').on('change', function() {
                // Xóa các giá trị hiện tại trước khi thêm các giá trị mới
                $('#selected-variant').empty();

                // Tạo một mảng để lưu trữ giá trị hiển thị
                let selectedVariants = [];

                // Lặp qua tất cả các checkbox đã được chọn
                $('.variant-checkbox:checked').each(function() {
                    // Lấy giá trị của từng checkbox đã chọn
                    let value = $(this).val();

                    // Khởi tạo optionValue là một mảng
                    let optionValue = [];

                    // Lặp qua mảng variants
                    variants.forEach(function(variant) {
                        // Kiểm tra xem option_name có trùng với giá trị checkbox không
                        if (variant.option_name === value) {
                            optionValue.push(variant.option_value);
                        }
                    });
                    // console.log(optionValue);

                    // Nếu có các option_value, tạo checkbox cho chúng
                    if (optionValue.length > 0) {
                        $('#selected-variant').append('<label>' + value + ':' + '</label><br/>');
                        optionValue.forEach(function(optValue) {
                            $('#selected-variant').append(
                                '<label class="form-check-label">' +
                                '<input type="checkbox" class="form-check-input option-value" name="option_value[]" value="' +
                                optValue + '">' + optValue +
                                '</label><br/>'
                            );
                        });
                    }
                });

                // Khi có ít nhất một biến thể được chọn, xử lý việc hiển thị bảng
                $('.option-value').on('change', function() {
                    // Xóa bảng trước khi thêm mới
                    $('#example tbody').empty();
                    let selectedVariants = [];

                    // Lấy giá trị từ checkbox "Loại" đã chọn
                    let selectedTypes = $('.variant-checkbox:checked').map(function() {
                        return $(this).val(); // Tên tùy chọn (ví dụ: 'Hộp' hoặc 'Túi')
                    }).get();

                    let selectedWeights = $('.option-value:checked').map(function() {
                        return $(this).val(); // Giá trị trọng lượng (ví dụ: '300g')
                    }).get();
                    types = [];
                    weight = [];
                    // console.log(variants);
                    selectedWeights.forEach(function(weight) {
                        selectedVariants.push(weight);
                    });
                    // Thêm dòng vào bảng cho mỗi biến thể đã chọn
                    selectedVariants.forEach(function(variant) {
                        $('#example tbody').append('<tr>' +
                            '<td>' + variant + '</td>' +
                            '<td>' +
                            '<input type="file" name="variant_image[]" class="form-control">' +
                            '</td>' +
                            '<td class="pr-4"><input name="variant_sku[]" type="text" class="form-control"></td>' +
                            '<td class="pr-4"><input name="variant_stock[]" type="text" class="form-control"></td>' +
                            '<td class="pr-4"><input name="variant_price[]" type="text" class="form-control"></td>' +
                            '</tr>');
                    });
                });
            });
        });
    </script>
    <script src="{{ asset('backend/js/product.js') }}"></script>
@endsection

@push('scriptHome')
    <!-- Summernote -->
    <script src="{{ asset('focus-2/focus-2/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ asset('focus-2/focus-2/js/plugins-init/summernote-init.js') }}"></script>
@endpush
