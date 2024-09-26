
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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Categories</h4>
                            </div>
                            <div class="card-body row">
                                <div class="col-4 ml-3 mr-5 border">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="mb-3">List Categories</h5>
                                            <div class="basic-list-group">
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <img src="#" alt="" width="50px" height="50px">
                                                       <h5> Cras justo odio</h5>
                                                        <div class="d-flex">
                                                            <a href="" class="badge badge-success badge-pill mr-1">Update</a>
                                                            <span href="" class="badge badge-danger badge-pill">Delete</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 border">
                                    <h5 class="m-3">Add New Category</h5>
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Name:</label>
                                            <input class="form-control" type="text" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Describe:</label>
                                            <input class="form-control" type="text" placeholder="Quanlity">
                                        </div>

                                        <div class="form-group">
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
                                        <button type="submit" name='submit' class="btn btn-secondary mb-3">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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



