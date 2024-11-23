@extends('user.layout.default')

@push('styleStore')
    <style>
        .order-status-menu {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            cursor: pointer;
        }

        .status-title {
            font-weight: bold;
            border: none;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 0px;
            background-color: #fff;
            flex-grow: 1;
            text-align: center;
            margin: 5px
        }

        .status-title:hover {
            background-color: #daddd4c7;
        }

        .order-details {
            display: none;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;

        }

        .order-item {
            padding: 10px;
            border: 1px solid #81C408;
            border-radius: 8px;
            background-color: #f9f9f9;
            width: calc(25% - 15px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;

        }

        .order-item .order-id {
            font-weight: bold;
            border-radius: 5%;
            padding: 5px;
            background-color: #fff;
            margin-top: 10px;
            border-radius: 8px;
        }

        .order-item img {
            max-width: 100%;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .view-details {
            text-decoration: none;
            color: #007bff;
        }

        .view-details:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
            <li class="breadcrumb-item active text-white">Đơn hàng</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Order History Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Đơn Hàng Của Bạn</h2>

                <!-- Menu trạng thái đơn hàng -->
                <div class="order-status-menu">
                    <div class="status-title" onclick="toggleOrderDetails('pending')">Chờ Xác Nhận</div>
                    <div class="status-title" onclick="toggleOrderDetails('awaiting')">Chờ Lấy Hàng</div>
                    <div class="status-title" onclick="toggleOrderDetails('shipping')">Chờ Giao Hàng</div>
                    <div class="status-title" onclick="toggleOrderDetails('delivered')">Đã Giao</div>
                    <div class="status-title" onclick="toggleOrderDetails('cancelled')">Đã Hủy</div>
                </div>
                @foreach ($orderLists as $value)
                <!-- Chi tiết đơn hàng -->
                <div id="pending" class="order-details">
                        @if ($value->orders->status == 1)
                        <h3>Đơn {{$value->order_id }}  <a href="#" class="view-details">Xem Chi Tiết</a></h3>
                        Tổng giá:{{number_format($value->orders->sum_price) }} vnđ <br>
                        Phí ship: 15,000 vnđ
                        <br>
                            @foreach ($productOrders as $item)
                                <div class="order-item">
                                    <img src="{{ asset($item->product_variants->image) }}"
                                    style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                    <br>
                                    {{ $item->products->name . ' - ' . $item->product_variants->sku }}
                                    <br>
                                    Số lượng: {{ $item->quantity }}
                                    Giá: {{ number_format($item->product_variants->price) }} vnđ
                                    <br>
                                </div>
                            @endforeach
                        @endif
                </div>

                <div id="awaiting" class="order-details">
                    @if ($value->orders->status == 2)
                    <h3>Đơn {{$value->order_id }}  <a href="#" class="view-details">Xem Chi Tiết</a></h3>
                    Tổng giá:{{number_format($value->orders->sum_price) }} vnđ <br>
                    Phí ship: 15,000 vnđ
                    <br>
                        @foreach ($productOrders as $item)
                            <div class="order-item">
                                <img src="{{ asset($item->product_variants->image) }}"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                <br>
                                {{ $item->products->name . ' - ' . $item->product_variants->sku }}
                                <br>
                                Số lượng: {{ $item->quantity }}
                                Giá: {{ number_format($item->product_variants->price) }} vnđ
                                <br>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div id="shipping" class="order-details">
                    @if ($value->orders->status == 3)
                    <h3>Đơn {{$value->order_id }}  <a href="#" class="view-details">Xem Chi Tiết</a></h3>
                    Tổng giá:{{number_format($value->orders->sum_price) }} vnđ <br>
                    Phí ship: 15,000 vnđ
                    <br>
                        @foreach ($productOrders as $item)
                            <div class="order-item">
                                <img src="{{ asset($item->product_variants->image) }}"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                <br>
                                {{ $item->products->name . ' - ' . $item->product_variants->sku }}
                                <br>
                                Số lượng: {{ $item->quantity }}
                                Giá: {{ number_format($item->product_variants->price) }} vnđ
                                <br>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div id="delivered" class="order-details">
                    @if ($value->orders->status == 4)
                    <h3>Đơn {{$value->order_id }}  <a href="#" class="view-details">Xem Chi Tiết</a></h3>
                    Tổng giá:{{number_format($value->orders->sum_price) }} vnđ <br>
                    Phí ship: 15,000 vnđ
                    <br>
                        @foreach ($productOrders as $item)
                            <div class="order-item">
                                <img src="{{ asset($item->product_variants->image) }}"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                <br>
                                {{ $item->products->name . ' - ' . $item->product_variants->sku }}
                                <br>
                                Số lượng: {{ $item->quantity }}
                                Giá: {{ number_format($item->product_variants->price) }} vnđ
                                <br>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div id="cancelled" class="order-details">
                    @if ($value->orders->status == 5)
                    <h3>Đơn {{$value->order_id }}  <a href="#" class="view-details">Xem Chi Tiết</a></h3>
                    Tổng giá:{{number_format($value->orders->sum_price) }} vnđ <br>
                    Phí ship: 15,000 vnđ
                    <br>
                        @foreach ($productOrders as $item)
                            <div class="order-item">
                                <img src="{{ asset($item->product_variants->image) }}"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                <br>
                                {{ $item->products->name . ' - ' . $item->product_variants->sku }}
                                <br>
                                Số lượng: {{ $item->quantity }}
                                Giá: {{ number_format($item->product_variants->price) }} vnđ
                                <br>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Order History End -->

    @push('scriptStore')
        <script>
            $('.status-title').on('click', function() {
                $('.status-title').css('border-bottom', 'none');
                $('.status-title').css('background-color', '#fff');
                $(this).css('background-color', '#f0ededba');
                $(this).css('border-bottom', '5px solid #81C408');
            });

            function toggleOrderDetails(status) {
                // Ẩn tất cả các chi tiết đơn hàng
                const allDetails = document.querySelectorAll('.order-details');
                allDetails.forEach(detail => {
                    detail.style.display = 'none';
                });

                // Hiển thị chi tiết đơn hàng tương ứng
                const selectedDetails = document.getElementById(status);
                selectedDetails.style.display = 'flex';

                // Ẩn các mục khác khi click vào một mục mới
                const statusTitles = document.querySelectorAll('.status-title');
                statusTitles.forEach(title => {
                    title.classList.remove('active'); // Bỏ chọn cho tất cả
                });
                document.querySelector(`.status-title[onclick="toggleOrderDetails('${status}')"]`).classList.add('active');
            }
        </script>
    @endpush
@endsection
