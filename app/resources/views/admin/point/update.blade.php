@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************Content body start***********************************-->
    <style>
        .list-order li:hover {
            cursor: pointer;
            background: rgba(160, 7, 225, 0.675);
        }

        .list-order li a {
            color: black;
        }

        .list-order {
            max-height: 300px;
            overflow-y: auto;
        }

        /* Tuỳ chỉnh thanh cuộn */
        .list-order::-webkit-scrollbar {
            width: 6px;
            /* Chiều rộng của thanh cuộn */
        }

        .list-order::-webkit-scrollbar-thumb {
            background-color: #ccc;
            /* Màu của thanh cuộn */
            border-radius: 4px;
            /* Bo góc thanh cuộn */
            transition: background-color 0.2s ease;
        }

        .list-order::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
            /* Màu khi hover */
        }

        .list-order::-webkit-scrollbar-track {
            background-color: #f0f0f0;
            /* Màu nền phía sau thanh cuộn */
            border-radius: 4px;
        }
    </style>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Cập nhật điểm thưởng</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Quản lý điểm thưởng</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Cập nhật điểm thưởng</a></li>
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Cập nhật điểm thưởng</h4>
                            <a href="{{ route('admin.listPoints') }}" class="btn btn-dark mr-3">Quay lại</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7 border ml-3 mr-4">
                                    <h5 class="m-3">Thông tin khách hàng</h5>
                                    <ul>
                                        <li class="mt-1">Tên khách hàng: {{ $point->users->name }}</li>
                                        <li class="mt-1">Email : {{ $point->users->email }}</li>
                                        <li class="mt-1">Số điện thoại : {{ $point->users->email }}</li>
                                        <li class="mt-1">Địa chỉ khách hàng:
                                            <ul class="ml-3">
                                                @foreach ($addresses as $key => $address)
                                                    <li> - Địa chỉ {{ $key + 1 }}:
                                                        {{ $address->home_address . ', ' . $address->address }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <form action="{{route('admin.updatePatchPoint')}}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <input type="text" name="user_id" value="{{ $point->users->id }}" hidden>
                                            <li> Điểm thưởng:
                                                <input type="number" name="point" value="{{ $point->point }}"
                                                    style="max-width: 227px;" class="form-control mt-2 mb-3">
                                            </li>
                                            <button class="btn btn-secondary">Cập nhật điểm</button>
                                        </form>
                                    </ul>
                                </div>
                                <div class="col-4 border pb-3">
                                    @php
                                        $count = 0;
                                    @endphp
                                    <h5 class="m-3"> Số đơn hàng</h5>
                                    <ul class="list-order rounded border mb-3" style="">
                                        @foreach ($listOrders as $value)
                                            @php
                                                $count++;
                                            @endphp
                                            <li class="border rounded m-2">
                                                <a href="{{route('admin.orderDetail',['order_id'=>$value->orders->id])}}">
                                                    <div class="d-flex mr-2">
                                                        <p class="mr-3 mt-2 ml-2">Mã đơn: {{ $value->orders->order_code }}
                                                        </p>
                                                        <p class="mt-2 mr-2">Tổng tiền:
                                                            {{ number_format($value->orders->sum_price) }} Vnđ</p>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <span> Tổng số lượng: {{ $count }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script></script>
@endsection

@push('scriptHome')
@endpush
