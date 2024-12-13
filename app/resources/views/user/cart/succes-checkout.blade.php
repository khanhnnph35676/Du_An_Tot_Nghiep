@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
    <style>

    </style>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white">Đặt hàng thành công</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row pt-3 border rounded">
                <h1 class="mb-4">Thông tin đơn hàng</h1>
                <div class="col-lg-6">

                    <div class="p-2 rounded" id="order-items">
                        <table class="table">
                            <p class="fs-5 m-2 text-dark fw-bold">Thông tin người đặt</p>
                            <tr>
                                <th>Email: </th>
                                {{-- <td>{{ $user->email }}</td> --}}
                            </tr>
                            <tr>
                                <th>Số điện thoại: </th>
                                {{-- <td>{{ $user->phone }}</td> --}}
                            </tr>
                            <tr>
                                <th>Phương thức thanh toán: </th>
                                {{-- <td>{{ $orderList->orders->payments->name }}</td> --}}
                            </tr>
                            <tr>
                                <th>Trang thái đơn: </th>
                                {{-- <td> --}}
                                {{-- @if ($orderList->orders->status == 1)
                                <strong class="border rounded p-1 text-dark fs-6 bg-white">Chờ Xác
                                    Nhận</strong>
                            @elseif($orderList->orders->status == 2)
                                <strong class="border rounded p-1 text-dark fs-6 bg-secondary">Chờ Lấy
                                    Hàng</strong>
                            @elseif($orderList->orders->status == 3)
                                <strong class="border rounded p-1 text-dark fs-6 bg-info">Đang Giao
                                    Hàng</strong>
                            @elseif($orderList->orders->status == 4)
                                <strong class="border rounded p-1 text-dark fs-6 bg-primary">Đã Giao
                                    Hàng</strong>
                            @elseif($orderList->orders->status == 5)
                                <strong class="border rounded p-1 text-dark fs-6 bg-danger">Đã
                                    Huỷ</strong>
                            @endif --}}
                                {{-- </td> --}}
                            </tr>
                            <tr>
                                <th>Địa chi nhận hàng: </th>
                                {{-- <td>{{ $orderList->orders->address->home_address . ', ' . $orderList->orders->address->address }} --}}
                                </td>
                            </tr>
                            <tr>
                                <th>Phí vận chuyển: </th>
                                <td>15.000 Vnđ</td>
                            </tr>
                            <tr>
                                <th>Phí vận chuyển: </th>
                                {{-- <td>{{ number_format($orderList->orders->sum_price) }} Vnđ</td> --}}
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <table class="table">
                        <p class="fs-5 m-2 text-dark fw-bold">Sản phẩm đã đặt</p>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá:</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($productOrders as $key => $item)
                                @if ($item->product_variant_id == null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->products->image) }}"
                                                style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                        </td>
                                        <td>{{ $item->products->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price) }} Vnđ</td>
                                    </tr>
                                @elseif($item->product_variant_id != null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ asset($item->product_variants->image) }}"
                                                style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                        </td>
                                        <td>{{ $item->products->name . ' - ' . $item->product_variants->sku }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price) }} Vnđ</td>
                                    </tr>
                                @endif
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
                <div class="text-end">
                    {{-- @if ($orderList->orders->status == 1)
                        <form action="{{ route('destroyOrder') }}" class="mt-3 text-end" method="POST">
                            @csrf
                            @method('patch')
                            <input type="text" value="{{ $orderList->orders->id }}" name='order_id' hidden>
                            <button class="btn btn-danger me-2">Huỷ đơn</button>
                        </form>
                    @endif --}}
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection

@push('scriptStore')
@endpush
