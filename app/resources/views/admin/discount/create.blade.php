@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************Content body start***********************************-->
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
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Thêm mới mã giảm giá</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách mã giảm giá</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm mới mã giảm giá</a></li>
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
                                <h4 class="card-title">Thêm mới mã giảm giá</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listDiscounts') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" name="submit" class="btn btn-secondary">Thêm mới</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 p-3 mr-4 ml-4 border">
                                        {{-- Form fields for product id, discount, priority, start date, and end date --}}
                                        <div class="form-group">
                                            <label for="">Mã giảm giá:</label>
                                            <input class="form-control" type="text" placeholder="Mã giảm giá"
                                                name="name">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Giảm theo phần trăm:</label>
                                            <input class="form-control" type="text" placeholder="Phần trăm"
                                                name="discount">
                                            @error('discount')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Độ ưu tiên:</label>
                                            <input class="form-control" type="text" placeholder="Độ ưu tiên"
                                                name="priority">
                                            @error('priority')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ngày bắt đầu: </label>
                                            <input class="form-control" type="date" name="start_date">
                                            @error('start_date')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ngày kết thúc:</label>
                                            <input class="form-control" type="date" name="end_date">
                                            @error('end_date')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
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
                                                    <span class="accordion__header--text"> Danh sách sản phẩm </span>
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
                                                                        <th>Tên sản phẩm</th>
                                                                        <th>Ảnh sản phẩm</th>
                                                                        <th>GIá</th>
                                                                        <th>Tồn kho</th>
                                                                        <th>Lượt xem</th>
                                                                        <th>Danh mục</th>
                                                                        <th>Loại</th>

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
