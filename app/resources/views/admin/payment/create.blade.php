@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************
                    Content body start
                ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Thêm Phương thức thanh toán</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Phương thức thanh toán</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm phương thức thanh toán</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    <form action="{{route('admin.payment.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Thêm phương thức thanh toán</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.formPayment') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" name="submit" class="btn btn-secondary">Thêm mới</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        <div class="form-group">
                                            <label for="">Tên phương thức:</label>
                                            <input class="form-control" type="text" placeholder="Tên phương thức" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="imageUpload">Ảnh:</label>
                                            <input type="file" class="form-control-file" name="image" accept="image/*">
                                        </div>
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
@endsection
@push('scriptHome')
@endpush
