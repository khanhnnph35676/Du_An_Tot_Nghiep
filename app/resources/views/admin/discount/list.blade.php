
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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List Orders</h4>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.createDiscount')}}" class="btn btn-secondary">Add Discount</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>Discount</th>
                                                <th>Priority</th>
                                                <th>Start Date</th>
                                                <th>End date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($discounts as $discount)
                                            <tr>
                                                <td>{{$discount->id}}</td>
                                                <td>{{$discount->products->name}}</td>
                                                <td>{{$discount->discount}}</td>
                                                <td>{{$discount->priority}}</td>
                                                <td>{{$discount->start_date}}</td>
                                                <td>{{$discount->end_date}}</td>
                                                <td>
                                                    <a href="{{ route('admin.updateDiscount', $discount->id)}}" class="btn btn-success">Update</a>
                                                    <form action="{{ route('admin.discount.destroy', $discount->id) }}" method="POST" style="display: inline-block;">  @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có muốn xóa {{$discount->name}} (Mã: {{$discount->id}}) không???')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
@endsection

@push('scriptHome')

@endpush



