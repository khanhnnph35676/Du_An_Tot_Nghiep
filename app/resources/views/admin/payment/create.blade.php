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
                                <h4 class="card-title">List of Payment method</h4>
                                <div class="d-flex">
                                    <button type="submit" name="submit" class="btn btn-secondary">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        {{-- form thêm cho product --}}
                                        <div class="form-group">
                                            <label for="">User id:</label>
                                            <input class="form-control" type="text" placeholder="User id" name="user_id">
                                        </div>
                                        <div class="form-group">
                                            <label for="">name:</label>
                                            <input class="form-control" type="text" placeholder="Name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Account Payments:</label>
                                            <input class="form-control" type="text" placeholder="Account Payments">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Account_payments:</label>
                                            <input class="form-control" type="text" placeholder="Address">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Enabled:</label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>Choose enable</option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
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
