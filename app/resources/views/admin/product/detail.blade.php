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
                    <form action="" method="POST">
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
                                        <div class="form-group">
                                            <label for="">Name:</label>
                                            <input class="form-control" type="text" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quanlity:</label>
                                            <input class="form-control" type="text" placeholder="Quanlity">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Price:</label>
                                            <input class="form-control" type="text" placeholder="Price">
                                        </div>
                                        <div class="form-group">
                                            <label>Variant options:</label>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="">Loại
                                                </label>
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="">Trọng
                                                    lượng
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Loại:</label>
                                            <div class="form-check form-check-inline">

                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="">Hộp
                                                </label>
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="">Túi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Trọng lượng:</label>
                                            <div class="form-check form-check-inline">

                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="">300g
                                                </label>
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="">500g
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <div class="form-group">
                                            <label>Category:</label>
                                            <select class="form-control" id="sel1">
                                                <option value="">Category 1</option>
                                                <option value="">Category 1</option>
                                                <option value="">Category 1</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- phần biến thể phải làm bằng front-end
                                        1,nếu click chọn loại thì in ra danh sách loại
                                        2,Chọn loại 2 cái nó sẽ in ra 2 bản ghi để thêm product varian  --}}

                                    <table class="table" id="example" class="display" style="width: 100%">
                                        <h5 class="mt-5">List Product</h5>
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
                                            <tr>
                                                <td>Hộp-300g</td>
                                                <td>
                                                    <div class="image-upload-container">
                                                        <label for="imageUpload" class="name_click">Image:</label>
                                                        <img id="imagePreview" src="#" alt="Image Preview"
                                                            style="display:none;" />
                                                        <input type="file" class="form-control-file" id="imageUpload"
                                                            accept="image/*">
                                                        <span style="button" class="btn btn-dark"
                                                            id="removeImage"style="display:none;">x</span>
                                                        {{-- thêm icon sau --}}
                                                    </div>
                                                </td>
                                                <td class="pr-4">
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td class="pr-4">
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td class="pr-4">
                                                    <input type="text" class="form-control">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
