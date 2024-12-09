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
                        <span class="ml-1">Cập nhật mã giảm giá</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách mã giảm giá</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Cập nhật mã giảm giá</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            @if (session('message'))
                <div class="message">
                    <div class="alert alert-primary alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                    class="mdi mdi-close"></i></span>
                        </button>
                        @if (session('message'))
                            <strong>{{ session('message') }}</strong>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.discount.update', $discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cập nhật mã giảm giá</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listDiscounts') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" name="submit" class="btn btn-secondary">Cập nhật</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 p-3 mr-4 ml-4 border">
                                        <div class="form-group">
                                            <label for="">Mã giảm giá:</label>
                                            <input class="form-control" type="text" placeholder="Discount" name="name"
                                                value="{{ $discount->name }}">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                            <input class="form-control" type="text" placeholder="Discount" name="id"
                                                value="{{ $discount->id }}" hidden>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Giảm theo phần trăm:</label>
                                            <input class="form-control" type="text" placeholder="Phần trăm"
                                                name="discount" value="{{ $discount->discount }}">
                                            @error('discount')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Độ ưu tiên:</label>
                                            <input class="form-control" type="text" placeholder="Đố ưu tiên"
                                                name="priority" value="{{ $discount->priority }}">
                                            @error('priority')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Số lượng:</label>
                                            <input class="form-control" type="text" placeholder="Số lượng"
                                                name="qty"  value="{{ $discount->qty }}">
                                            @error('qty')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ngày bắt đầu:</label>
                                            <input class="form-control" type="date" placeholder="Ngày/Tháng/Năm"
                                                name="start_date" value="{{ $discount->start_date }}">
                                            @error('start_date')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ngày kết thúc:</label>
                                            <input class="form-control" type="date" placeholder="Ngày/Tháng/Năm"
                                                name="end_date" value="{{ $discount->end_date }}">
                                            @error('end_date')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
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
                                                                        <th>Giá</th>
                                                                        <th>Tồn kho</th>
                                                                        <th>Lượt xem</th>
                                                                        <th>Danh mục</th>
                                                                        <th>Loại</th>

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
                                                                                        @endif @endforeach
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
                                                                            <td> {{ $value->categories ? $value->categories->name : 'Không có danh mục' }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($value->type == '1')
                                                                                    <span
                                                                                        class='badge badge-pill badge-success'>
                                                                                        Đơn thể</span>
                                                                                @else
                                                                                    <span
                                                                                        class='badge badge-pill badge-secondary'>
                                                                                        Có biến thể </span>
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
