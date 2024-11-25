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
                    <form action="{{route('admin.payment.update',$payment->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Payment method</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.formPayment') }}" class="btn btn-dark mr-3">Back</a>
                                    <button type="submit" name="submit" class="btn btn-secondary">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        <div class="form-group">
                                            <label for="">Name:</label>
                                            <input class="form-control" type="text" placeholder="Name" name="name" value="{{$payment->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="imageUpload">Image:</label>
                                            <input type="file" class="form-control-file" name="image" accept="image/*">
                                            @if ($payment->image)
                                                <img src="{{ asset($payment->image) }}" class="mt-3"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
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
