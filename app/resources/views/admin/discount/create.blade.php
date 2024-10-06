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
                <form action="{{route('admin.discount.store')}}" method="POST">
                    @csrf
                    <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Discount</h4>
                        <div class="d-flex">
                        <a href="{{ route('admin.listDiscounts') }}" class="btn btn-dark mr-3">Back</a>
                        <button type="submit" name="submit" class="btn btn-secondary">Save</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-12 p-3 mr-4 ml-4 border">
                            {{-- Form fields for product id, discount, priority, start date, and end date --}}
                            <div class="form-group">
                            <label for="">Product id:</label>
                            <input class="form-control" type="text" placeholder="Product id" name="product_id">
                            </div>
                            <div class="form-group">
                            <label for="">Discount:</label>
                            <input class="form-control" type="text" placeholder="Discount" name="discount">
                            </div>
                            <div class="form-group">
                            <label for="">Priority:</label>
                            <input class="form-control" type="text" placeholder="Priority" name="priority">
                            </div>
                            <div class="form-group">
                            <label for="">Start date:</label>
                            <input class="form-control" type="date" placeholder="Start date" name="start_date">
                            </div>
                            <div class="form-group">
                            <label for="">End date:</label>
                            <input class="form-control" type="date" placeholder="End date" name="end_date">
                            </div>
                        </div>
                        {{-- Optional: Add another column if needed --}}
                        {{-- <div class="col-3 p-3 border">
                            ...
                        </div> --}}
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
