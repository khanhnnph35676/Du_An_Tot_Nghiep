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
                                <a href="" class="btn btn-secondary">Add Order</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Stt</th>
                                            <th>Mã Order</th>
                                            <th>Người dùng</th>

                                            {{-- <th>Địa chỉ</th> --}}
                                            <th>Tổng tiền</th>
                                            <th>Ngày đặt</th>
                                            <th class="text-center">Thanh toán</th>
                                            <th>Trang thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderLists as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $value->orders->order_code }}</td>
                                                <td>{{ $value->users->email }}</td>

                                                {{-- <td>
                                                    @if ($value->orders && $value->orders->address)
                                                        {{ $value->orders->address->address }}
                                                    @else
                                                        <p>No address found</p>
                                                    @endif
                                                </td> --}}
                                                <td> {{ number_format($value->orders->sum_price) }} vnđ</td>
                                                <td>{{ $value->orders->created_at }}</td>
                                                <td class="text-center">{{$value->orders->payments->name?$value->orders->payments->name:'No address found'}}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-light">{{ $value->orders->status == 1 ? 'Chờ xác nhận' : '' }}</span>
                                                    <span
                                                        class="badge badge-warning">{{ $value->orders->status == 2 ? 'Chờ lấy hàng' : '' }}</span>
                                                    <span
                                                        class="badge badge-info">{{ $value->orders->status == 3 ? 'Đang giao hàng' : '' }}</span>
                                                    <span
                                                        class="badge badge-success">{{ $value->orders->status == 4 ? 'Đã giao hàng' : '' }}</span>
                                                    <span
                                                        class="badge badge-danger">{{ $value->orders->status == 5 ? 'Đã huỷ' : '' }}</span>

                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.orderDetail', ['order_id' => $value->order_id]) }}"
                                                        class="btn btn-primary">Chi tiết</button>
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
