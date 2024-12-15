@extends('user.layout.default')

@push('styleStore')
@endpush
<style>
    .side-bar li {
        display: block;
        border-bottom: 1px solid black;
    }

    .side-bar {
        min-height: 300px;
    }
</style>
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi tiết đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Lịch sử đơn hàng</a></li>
            <li class="breadcrumb-item active text-white">Chi tiết đơn hàng</li>
        </ol>
    </div>
    <!-- Order History Start -->
    @php
        $count = 0;
    @endphp
    @foreach ($orderLists as $item)
        @if ($item->orders->status != 5)
            @php
                $count += 1;
            @endphp
        @endif
    @endforeach
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <ul class="side-bar border rounded p-1">
                    <h3 class="mb-4 mt-3 ms-3">Chi tiết đơn hàng</h3>
                    <li class="p-2 mt-2"><a href="{{ route('user.profile') }}" class="text-dark"><strong>Thông tin cá
                                nhân</strong> </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('order.history') }}" class="text-dark"><strong>Đơn hàng
                                ({{ $count }})</strong>
                        </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('points') }}" class="text-dark"><strong>Điểm thưởng</strong>
                        </a> </li>
                </ul>
            </div>
            <div class="col-lg-9  border rounded">
                <p class="fs-4 m-2 text-dark fw-bold">Chi tiết đơn hàng</p>
                <div class="p-2 rounded" id="order-items">
                    <table class="table">
                        <p class="fs-5 m-2 text-dark fw-bold">Thông tin người đặt</p>
                        <tr>
                            <th>Email: </th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại: </th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán: </th>
                            <td>{{ $orderList->orders->payments->name }}</td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán: </th>
                            <td>
                                @if ($orderList->orders->check_payment_id == 1)
                                <strong class="border rounded p-1 text-dark fs-6 bg-primary">Đã thanh toán</strong>
                                @else
                                <strong class="border rounded p-1 text-dark fs-6 bg-white">Chưa thanh toán</strong>
                                @endif
                        </tr>
                        <tr>
                            <th>Trang thái đơn: </th>
                            <td>
                                @if ($orderList->orders->status == 0)
                                <strong class="border rounded p-1 text-dark fs-6 bg-white">Chờ Xác
                                    Nhận</strong>
                                @elseif($orderList->orders->status == 1)
                                    <strong class="border rounded p-1 text-dark fs-6 bg-secondary">Chờ Lấy
                                        Hàng</strong>
                                @elseif($orderList->orders->status == 3 || $orderList->orders->status == 2)
                                    <strong class="border rounded p-1 text-dark fs-6 bg-info">Đang Giao
                                        Hàng</strong>
                                @elseif($orderList->orders->status == 4)
                                    <strong class="border rounded p-1 text-dark fs-6 bg-primary">Đã Giao
                                        Hàng</strong>
                                @elseif($orderList->orders->status == 5)
                                    <strong class="border rounded p-1 text-white fs-6 bg-danger">Đã
                                        Huỷ</strong>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Địa chi nhận hàng: </th>
                            <td>{{ $orderList->orders->address->home_address ? $orderList->orders->address->home_address . ', ' . $orderList->orders->address->address:'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Phí vận chuyển: </th>
                            <td>15.000 Vnđ</td>
                        </tr>
                        <tr>
                            <th>Phí vận chuyển: </th>
                            <td>{{ number_format($orderList->orders->sum_price) }} Vnđ</td>
                        </tr>
                    </table>
                    <table class="table">
                        <p class="fs-5 m-2 text-dark fw-bold">Sản phẩm đã đặt</p>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá:</th>
                                @if ($orderList->orders->status == 4)
                                <td></td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productOrders as $key=> $item)
                                @if ($item->product_variant_id == null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->products->image) }}"
                                            style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                        </td>
                                        <td>{{Str::words(strip_tags( $item->products->name), 6, '...') }} </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price) }} Vnđ</td>

                                        @if ($orderList->orders->status == 4)
                                        <td><button type="button" class="btn btn-primary">Đánh giá</button></td>
                                        @endif
                                    </tr>
                                @elseif($item->product_variant_id != null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ asset($item->product_variants->image) }}"
                                                style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                            </td>
                                        <td>{{Str::words(strip_tags( $item->products->name . ' - ' . $item->product_variants->sku ), 6, '...') }} </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price) }} Vnđ</td>
                                        @if ($orderList->orders->status == 4)
                                        <td><button type="button" class="btn btn-primary">Đánh giá</button></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="text-end">
                    @if ($orderList->orders->status == 0)
                    <form action="{{ route('destroyOrder') }}" class="mt-3 text-end" method="POST">
                        @csrf
                        @method('patch')
                        <input type="text" value="{{ $orderList->orders->id }}" name='order_id' hidden>
                        <button class="btn btn-danger me-2">Huỷ đơn</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scriptStore')
    @endpush
@endsection
