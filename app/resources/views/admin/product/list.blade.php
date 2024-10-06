
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
                <div class="message">
                    <div class="alert alert-primary alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                        <strong>Success!</strong> Message has been sent.
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List Product</h4>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Add Product</button>
                                    <div class="dropdown-menu bg-secondary mr-3">
                                        <div class="d-flex flex-column">
                                            <a href="{{route('admin.productSimple')}}" class='btn btn-secondary'>Product Simple</a>
                                            <a href="{{route('admin.productDetail')}}" class='btn btn-secondary'>Product Configurable</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Price</th>
                                                <th>Stick</th>
                                                <th>View</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listProducts as $key => $value):
                                            <tr>
                                                <td> {{ $value->id }}  </td>
                                                <td> {{ $value->name }}  </td>
                                                <td> {{ $value->image }} </td>
                                                <td> {{ $value->price }} </td>
                                                <td> {{ $value->qty }} </td>
                                                <td> {{ $value->view }} </td>
                                                <td> {{ $value->categories->name }} </td>
                                                <td style="width:20%;"> {{ Str::limit($value->description, 20) }} </td>
                                                <td>
                                                    @if($value->type == 'Simple'):
                                                     <span class='badge badge-pill badge-success'> {{$value->type }}</span>
                                                    @else
                                                     <span class='badge badge-pill badge-secondary'> {{$value->type }}</span>
                                                    @endif
                                                </td>
                                                <td style="width:13%;">
                                                    <a href=""class='badge badge-pill badge-primary'>Update</a>
                                                    <a href=""class='badge badge-pill badge-danger'>Delete</a>
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



