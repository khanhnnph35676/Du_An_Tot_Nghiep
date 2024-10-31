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
                    <form action="{{ route('admin.discount.update', $discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update New Discount</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listDiscounts') }}" class="btn btn-dark mr-3">Back</a>
                                    <button type="submit" name="submit" class="btn btn-secondary">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 p-3 mr-4 ml-4 border">
                                        <div class="form-group">
                                            <label for="">Name Discount:</label>
                                            <input class="form-control" type="text" placeholder="Discount"
                                                name="name" value="{{ $discount->name }}">
                                            <input class="form-control" type="text" placeholder="Discount"
                                                name="id" value="{{ $discount->id }}" hidden>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Discount:</label>
                                            <input class="form-control" type="text" placeholder="Discount"
                                                name="discount" value="{{ $discount->discount }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Priority:</label>
                                            <input class="form-control" type="text" placeholder="Priority"
                                                name="priority" value="{{ $discount->priority }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Start date:</label>
                                            <input class="form-control" type="date" placeholder="Start date"
                                                name="start_date" value="{{ $discount->start_date }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">End date:</label>
                                            <input class="form-control" type="date" placeholder="End date"
                                                name="end_date" value="{{ $discount->end_date }}">
                                        </div>
                                        <div id="accordion-four" class="accordion accordion-no-gutter accordion-bordered">
                                            <div class="accordion__item">
                                                <div class="accordion__header collapsed" data-toggle="collapse"
                                                    data-target="#bordered_no-gutter_collapseThree">
                                                    <span class="accordion__header--text"> Select products </span>
                                                    <span class="accordion__header--indicator style_two"></span>
                                                </div>
                                                <div id="bordered_no-gutter_collapseThree" class="collapse accordion__body"
                                                    data-parent="#accordion-four">
                                                    <div class="accordion__body--text">
                                                        <div class="table-responsive">
                                                            <table id="example" class="display">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="checkAll"></th>
                                                                        <th>Id</th>
                                                                        <th>Name</th>
                                                                        <th>Image</th>
                                                                        <th>Price</th>
                                                                        <th>Stock</th>
                                                                        <th>View</th>
                                                                        <th>Category</th>
                                                                        <th>Type</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($products as $key => $value)
                                                                        <tr>
                                                                            <td><input type="checkbox" name="product_id[]"
                                                                                    value=" {{ $value->id }}"
                                                                                    @foreach ($discountProduct as $item)
                                                                                        @if ($item['product_id'] == $value->id)
                                                                                            checked
                                                                                        @endif
                                                                                    @endforeach
                                                                                    class="checkItem">
                                                                            </td>
                                                                            <td> {{ $value->id }} </td>
                                                                            <td> {{ $value->name }} </td>
                                                                            <td> <img src="{{ asset($value->image) }}"
                                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                                    alt="">
                                                                                @php
                                                                                    $count = 0;
                                                                                @endphp

                                                                                @foreach ($galleries as $gallerie)
                                                                                    @if ($gallerie->product_id == $value->id && $count < 1)
                                                                                        <img src="{{ asset($gallerie->image) }}"
                                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                                            alt="">
                                                                                        @php
                                                                                            $count++;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if ($count == 1)
                                                                                    ...
                                                                                @endif
                                                                            </td>
                                                                            <td> {{ number_format($value->price) }}
                                                                                vnđ </td>
                                                                            <td> {{ $value->qty }} </td>
                                                                            <td> {{ $value->view }} </td>
                                                                            <td> {{ $value->categories ? $value->categories->name : 'No Category' }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($value->type == '1')
                                                                                    <span
                                                                                        class='badge badge-pill badge-success'>
                                                                                        Simple</span>
                                                                                @else
                                                                                    <span
                                                                                        class='badge badge-pill badge-secondary'>
                                                                                        Configurable </span>
                                                                                @endif
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
