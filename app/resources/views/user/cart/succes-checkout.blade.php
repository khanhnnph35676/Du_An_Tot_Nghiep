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
                <div class="col-lg-7">

                    <div class="p-2 rounded" id="order-items">
                        <table class="table">
                            <p class="fs-5 m-2 text-dark fw-bold">Thông tin người đặt</p>
                            <tr>
                                <th>Email: </th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại: </th>
                                <td>{{ Auth::user()->phone }}</td>
                            </tr>
                        </table>
                        <table class="table">
                            <p class="fs-5 m-2 text-dark fw-bold">Thông tin đơn hàng</p>
                            <tr>
                                <th>Phương thức thanh toán: </th>
                                <td>{{ $order->payments->name }}</td>
                            </tr>
                            <tr>
                                <th>Trang thái đơn: </th>
                                <td>
                                    @if ($order->status == 0)
                                        <strong class="border rounded p-1 text-dark fs-6 bg-white">Chờ Xác Nhận</strong>
                                    @endif
                                    @if ($order->check_payment_id == 0)
                                        <strong class="border rounded p-1 text-dark fs-6 bg-white">Chưa thanh toán</strong>
                                    @elseif($order->check_payment_id == 1)
                                        <strong class="border rounded p-1 text-primary fs-6 bg-white">Đã thanh toán</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Phí vận chuyển: </th>

                                <td>
                                    @if ($user_voucher != [])
                                        {{ $user_voucher->sale == 0 ? 0 : 15.0 }} Vnđ
                                    @else
                                        15.000 Vnđ
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Tổng tiền: </th>
                                <td>{{ number_format($order->sum_price) }} Vnđ</td>
                            </tr>
                            <tr>
                                <th>Địa chi nhận hàng: </th>
                                <td>{{ $order->address->home_address . ', ' . $order->address->address }}
                                </td>
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
                            @foreach ($productOrders as $key => $item)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <a href="{{ route('order.history') }}" class="btn btn-secondary">Xem Lịch sử đơn hàng</a>
                    @if ($order->status == 0)
                        <form action="{{ route('destroyOrder') }}" class="mt-3 text-end" method="POST">
                            @csrf
                            @method('patch')
                            <input type="text" value="{{ $order->id }}" name='order_id' hidden>
                            <button class="btn btn-danger me-2 mb-3">Huỷ đơn</button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection

@push('scriptStore')
@endpush
