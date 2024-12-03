@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Chi tiết đơn hàng</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách đơn hàng</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Chi tiết đơn hàng</a></li>
                    </ol>
                </div>
            </div>

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
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    @foreach ($orderList as $order)
                        <form action="{{ route('admin.updateOrder', ['order_id' => $order->order_id]) }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h2>Chi tiết đơn hàng</h2>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.listOrders') }}" class="btn btn-dark mr-3">Quay lại</a>
                                        <button type="submit" name="submit" class="btn btn-secondary">Cập nhật</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8 mr-4">
                                            <div class="row border p-2 mb-3">
                                                <div class="col-12">
                                                    <div class="user-info">
                                                        <h3>Thông tin khách hàng</h3>
                                                        <ul>
                                                            <li>Tên khách hàng: {{ $order->users->name }}</li>
                                                            <li>Email: {{ $order->users->email }}</li>
                                                            <li>Số điện thoại: {{ $order->users->phone }}</li>
                                                            <li>Địa chỉ giao hàng:
                                                                @if (isset($order->orders->address))
                                                                    {{ $order->orders->address->home_address .' , '. $order->orders->address->address }}
                                                                @endif
                                                            </li>
                                                            <li>Mã đơn hàng: {{$order->orders->order_code}} </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border p-2">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display">
                                                            <div class="head-line d-flex align-items-center">
                                                                <h3 class="m-0 mr-3">Đơn hàng </h3>
                                                                <span
                                                                    class="badge badge-light">{{ $order->orders->status == 1 ? 'Chờ xác nhận' : '' }}</span>
                                                                <span
                                                                    class="badge badge-warning">{{ $order->orders->status == 2 ? 'Chờ lấy hàng' : '' }}</span>
                                                                <span
                                                                    class="badge badge-info">{{ $order->orders->status == 3 ? 'Đang giao hàng' : '' }}</span>
                                                                <span
                                                                    class="badge badge-success">{{ $order->orders->status == 4 ? 'Đã giao hàng' : '' }}</span>
                                                                <span
                                                                    class="badge badge-danger">{{ $order->orders->status == 5 ? 'Đã huỷ' : '' }}</span>
                                                            </div>
                                                            <thead>
                                                                <tr>
                                                                    <th>Stt</th>
                                                                    <th>Sản phẩm</th>
                                                                    <th>Giá</th>
                                                                    <th class="text-center">Số lượng</th>
                                                                    <th>Thời gian đặt</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($data as $key => $value)
                                                                    {{-- @php
                                                                    print_r($value->product_variants);
                                                                @endphp --}}
                                                                    {{-- @foreach ($value->product_variants as $product_variant) --}}
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>
                                                                            @if ($value->products->type == 1)
                                                                                <a href="{{ route('admin.formUpdateProductSimple', ['type' => $value->products->type, 'idProduct' => $value->products->id]) }}"
                                                                                    class="text-primary">
                                                                                    <img src="{{ asset($value->products->image) }}"
                                                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                                                        alt="">
                                                                                    {{ $value->products->name }}
                                                                                </a>
                                                                            @else
                                                                                <a href="{{ route('admin.formUpdateProductConfigurable', ['type' => $value->products->type, 'idProduct' => $value->products->id]) }}"
                                                                                    class="text-primary">
                                                                                    <img src="{{ asset($value->product_variants->image) }}"
                                                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                                                        alt="">
                                                                                    {{ $value->products->name . ' - ' . $value->product_variants->sku }}
                                                                                </a>
                                                                            @endif

                                                                        </td>
                                                                        <td> {{ number_format($value->price) }}
                                                                            vnđ </td>
                                                                        <td class="text-center">{{ $value->quantity }}</td>
                                                                        <td>{{ $value->created_at }}</td>
                                                                    </tr>
                                                                    {{-- @endforeach --}}
                                                                @endforeach
                                                                {{-- Hàng cuối cùng cho tổng giá --}}
                                                                <tr>
                                                                    <td colspan="1"><strong>Tổng giá:</strong>
                                                                    </td>
                                                                    <td colspan="4">
                                                                        <strong>{{ number_format($order->orders->sum_price) }}
                                                                            vnđ</strong>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 p-3 border side-bar">
                                            <h3>Điều chỉnh trạng thái</h3>
                                            <div class="form-group">
                                                <label>Trạng thái:</label>
                                                <select id="single-select" name="status">
                                                    <option value="1"
                                                        {{ $order->orders->status == 1 ? 'selected' : '' }}>
                                                        Chờ xác nhận
                                                    </option>
                                                    <option value="2"
                                                        {{ $order->orders->status == 2 ? 'selected' : '' }}>
                                                        Chờ lấy hàng
                                                    </option>
                                                    <option value="3"
                                                        {{ $order->orders->status == 3 ? 'selected' : '' }}>
                                                        Đang giao hàng
                                                    </option>
                                                    <option value="4"
                                                        {{ $order->orders->status == 4 ? 'selected' : '' }}>
                                                        Đã giao hàng
                                                    </option>
                                                    <option value="5"
                                                        {{ $order->orders->status == 5 ? 'selected' : '' }}>
                                                        Đã huỷ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
                                                            Content body end
                                                        ***********************************-->
    <script src="{{ asset('backend/js/product.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById("single-select");
            const currentStatus = parseInt(select.value); // Trạng thái hiện tại

            // Loại bỏ các lựa chọn không hợp lệ
            Array.from(select.options).forEach(option => {
                const value = parseInt(option.value);

                // Chỉ cho phép chọn trạng thái liền kề (trước hoặc sau)
                if (value !== currentStatus && value !== currentStatus + 1) {
                    option.disabled = true; // Disable các trạng thái không hợp lệ
                }
            });

            // Kiểm tra khi người dùng thay đổi giá trị
            select.addEventListener("change", function() {
                const selectedValue = parseInt(this.value);

                // Chỉ cho phép chọn trạng thái liền kề
                if (selectedValue !== currentStatus && selectedValue !== currentStatus + 1) {
                    alert("Bạn chỉ có thể chọn trạng thái tiếp theo!");
                    this.value = currentStatus; // Khôi phục trạng thái cũ
                }
            });
        });
    </script>
@endsection


@push('scriptHome')
@endpush
