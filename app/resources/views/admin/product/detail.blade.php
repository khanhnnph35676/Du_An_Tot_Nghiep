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
                        <h4>Hi, welcome back!</h4>
                        <span class="ml-1">Datatable</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
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
                                <h4 class="card-title">Add New Product Configurable</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listProducts') }}" class="btn btn-dark mr-3">Back</a>
                                    <button type="submit" type="submit" class="btn btn-secondary">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        {{-- form thêm cho product --}}
                                        {{-- <input class="form-control" type="text" placeholder="Name" name="id" hidden> --}}
                                        <div class="form-group">
                                            <label for="">Name:</label>
                                            <input class="form-control" type="text" placeholder="Name" name="name">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quanlity:</label>
                                            <input class="form-control" type="text" name='qty' placeholder="Quanlity"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Price:</label>
                                            <input class="form-control" type="text" name="price" placeholder="Price">
                                            @error('price')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Variant options:</label>
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
                                            <label>Category:</label>
                                            <select class="form-control" id="sel1" name='category_id'>
                                                @foreach ($categories as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="gallerie_image[]" accept="image/*"multiple>
                                        </div>
                                    </div>
                                    {{-- phần biến thể phải làm bằng front-end
                                        1,nếu click chọn loại thì in ra danh sách loại
                                        2,Chọn loại 2 cái nó sẽ in ra 2 bản ghi để thêm product varian  --}}
                                    <div class="card-body border mt-3">
                                        <div class="table-responsive">
                                            <table id="example" class="display">
                                                <thead>
                                                    <tr>
                                                        <th>Option Value</th>
                                                        <th>Image</th>
                                                        <th>Sku</th>
                                                        <th>Stick</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                @error('variant_sku')
                                                    <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('variant_stock')
                                                    <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('variant_price')
                                                    <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('option_value')
                                                    <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                    </div>
                                                @enderror

                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3" style="width: 100%">
                                        <h5>Description</h5>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                            '<div class="image-upload-container">' +
                            '<label for="imageUpload" class="name_click">Image:</label>' +
                            '<img id="imagePreview" src="#" alt="Image Preview" style="display:none;" />' +
                            '<input type="file" name="variant_image" class="form-control-file" id="imageUpload" accept="image/*">' +
                            '<span style="button" class="btn btn-dark" id="removeImage" style="display:none;">x</span>' +
                            '</div>' +
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
