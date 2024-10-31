@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************
                                                                    Content body start

                                                                    ***********************************-->
    <style>
        .checkItem {
            text-align: center;
            display: flex;
            max-width: 30px;
        }
    </style>
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
                    <form action="{{ route('admin.discount.store') }}" method="POST">
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
                                            <label for="">Name Discount:</label>
                                            <input class="form-control" type="text" placeholder="Name Discount"
                                                name="name">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Discount:</label>
                                            <input class="form-control" type="text" placeholder="Discount"
                                                name="discount">
                                            @error('discount')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Priority:</label>
                                            <input class="form-control" type="text" placeholder="Priority"
                                                name="priority">
                                            @error('priority')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Start date:</label>
                                            <input class="form-control" type="date" placeholder="Start date"
                                                name="start_date">
                                            @error('start_date')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">End date:</label>
                                            <input class="form-control" type="date" placeholder="End date"
                                                name="end_date">
                                            @error('end_date')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="">idpro</label>
                                            <input class="form-control" type="text" placeholder="End date"
                                                name="product_id">
                                        </div> --}}
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
                                                                            <td>
                                                                                <input type="checkbox" name="product_id[]"
                                                                                    value=" {{ $value->id }}"
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
    <script>
        // Lắng nghe sự kiện click trên checkbox chính
        document.getElementById('checkAll').addEventListener('click', function(e) {
            // Lấy tất cả các checkbox trong tbody có class là 'checkItem'
            let checkboxes = document.querySelectorAll('.checkItem');

            // Lặp qua các checkbox và đặt giá trị của chúng bằng với checkbox chính
            checkboxes.forEach((checkbox) => {
                checkbox.checked = e.target.checked;
            });
        });
        window.onload = function() {
            // Tự động ẩn thông báo lỗi sau 1 giây
            var errorElements = document.querySelectorAll('.alert-danger');
            errorElements.forEach(function(errorElement) {
                setTimeout(function() {
                    errorElement.style.display = 'none'; // Ẩn thông báo
                }, 2000); // 1000 milliseconds = 1 second
            });
        };
    </script>
@endsection
@push('scriptHome')
@endpush
