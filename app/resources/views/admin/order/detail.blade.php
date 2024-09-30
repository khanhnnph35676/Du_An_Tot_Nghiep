@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <!--**********************************
                    Content body start
                ***********************************-->
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
                                <h4 class="card-title">Add New Customer</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listOrders') }}" class="btn btn-dark mr-3">Back</a>
                                    <button type="submit" name="submit" class="btn btn-secondary">Save</button>
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
                                            <label for="">Email:</label>
                                            <input class="form-control" type="text" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone:</label>
                                            <input class="form-control" type="text" placeholder="Phone">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address:</label>
                                            <input class="form-control" type="text" placeholder="Adrress">
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <div class="form-group">
                                            <label for="">Gener:</label>
                                            <div class="basic-form">
                                                <form>
                                                    <div class="form-group">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="gener"> Nam</label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="gener" class="ml-3"> Nữ</label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="gener" class="ml-3">
                                                            Khác</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Image:</label>
                                            <div class="image-upload-container">
                                                <label for="imageUpload" class="name_click">Image:</label>
                                                <img id="imagePreview" src="#" alt="Image Preview"
                                                    style="display:none;" />
                                                <input type="file" class="form-control-file" id="imageUpload"
                                                    accept="image/*">
                                                <span style="button" class="btn btn-dark"
                                                    id="removeImage"style="display:none;">x</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Birth:</label>
                                           <input type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--**********************************
                    Content body end
                ***********************************-->
                <script src="{{ asset('backend/js/product.js') }}"></script>
@endsection


@push('scriptHome')
@endpush
