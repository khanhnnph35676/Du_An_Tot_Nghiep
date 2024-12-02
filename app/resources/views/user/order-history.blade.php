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
            display: grid;
            margin-top: 15px;
        }

        .order-item {
            padding: 10px;
            border: 1px solid #c0c1be;
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

        .side-bar {
            min-height: 300px;
        }

        .side-bar li {
            display: block;
            border-bottom: 1px solid black;

        }

        .side-bar li:hover {
            background: #b9b7b793;
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
        <!-- Single Page Header End -->
        @if (session('message'))
            <div class="message">
                <div class="alert alert-primary alert-dismissible alert-alt solid fade show">
                    @if (session('message'))
                        <strong>{{ session('message') }}</strong>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-3">
                <ul class="side-bar border rounded p-1">
                    <h3 class="mb-4 mt-3">Đơn Hàng</h3>
                    <li class="p-2"><a href="{{ route('user.profile') }}" class="text-dark"><strong>Thông tin cá
                                nhân</strong> </a> </li>
                    <li class="p-2"><a href="{{ route('order.history') }}" class="text-dark"><strong>Đơn hàng
                                ({{ $count }})</strong>
                        </a> </li>
                </ul>
            </div>
            <div class="col-9">
                <!-- Menu trạng thái đơn hàng -->
                <div class="order-status-menu">
                    <div class="status-title" onclick="toggleOrderDetails('pending')">Chờ Xác Nhận</div>
                    <div class="status-title" onclick="toggleOrderDetails('awaiting')">Chờ Lấy Hàng</div>
                    <div class="status-title" onclick="toggleOrderDetails('shipping')">Chờ Giao Hàng</div>
                    <div class="status-title" onclick="toggleOrderDetails('delivered')">Đã Giao</div>
                    <div class="status-title" onclick="toggleOrderDetails('cancelled')">Đã Hủy</div>
                </div>

                <!-- Chi tiết đơn hàng -->
                <div id="pending" class="order-details">
                    @foreach ($orderLists as $value)
                        @if ($value->orders->status == 1)
                            <div class="border p-2 rounded" style="width:100%;">
                                <ul>
                                    <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                        <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-white">Chờ Xác Nhận</strong>
                                    </li>
                                    <li> Địa chỉ:
                                        {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                    </li>
                                    <li> Phí vận chuyển: 15,000 vnđ</li>
                                    <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                    </li>
                                </ul>
                                <div class="border p-2 rounded d-flex gap-2">
                                    @foreach ($productOrders as $item)
                                        @if ($item->order_id == $value->order_id && $item->product_variant_id == null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->products->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @elseif($item->order_id == $value->order_id && $item->product_variant_id != null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->product_variants->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name . ' - ' . $item->product_variants->sku }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div id="awaiting" class="order-details">
                    @foreach ($orderLists as $value)
                        @if ($value->orders->status == 2)
                            <div class="border p-2 rounded" style="width:100%;">
                                <ul>
                                    <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                        <strong class="ms-3 border rounded p-1 text-white fs-6 bg-secondary">Chờ Lấy Hàng</strong>
                                    </li>
                                    <li> Địa chỉ:
                                        {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                    </li>
                                    <li> Phí vận chuyển: 15,000 vnđ</li>
                                    <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                    </li>
                                </ul>
                                <div class="border p-2 rounded d-flex gap-2">
                                    @foreach ($productOrders as $item)
                                        @if ($item->order_id == $value->order_id && $item->product_variant_id == null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->products->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @elseif($item->order_id == $value->order_id && $item->product_variant_id != null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->product_variants->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name . ' - ' . $item->product_variants->sku }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div id="shipping" class="order-details">
                    @foreach ($orderLists as $value)
                        @if ($value->orders->status == 3)
                            <div class="border p-2 rounded" style="width:100%;">
                                <ul>
                                    <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                        <strong class="ms-3 border rounded p-1 text-white fs-6 bg-primary">Đang giao hàng</strong>
                                    </li>
                                    <li> Địa chỉ:
                                        {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                    </li>
                                    <li> Phí vận chuyển: 15,000 vnđ</li>
                                    <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                    </li>
                                </ul>
                                <div class="border p-2 rounded d-flex gap-2">
                                    @foreach ($productOrders as $item)
                                        @if ($item->order_id == $value->order_id && $item->product_variant_id == null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->products->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @elseif($item->order_id == $value->order_id && $item->product_variant_id != null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->product_variants->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name . ' - ' . $item->product_variants->sku }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div id="delivered" class="order-details">
                    @foreach ($orderLists as $value)
                        @if ($value->orders->status == 4)
                            <div class="border p-2 rounded" style="width:100%;">
                                <ul>
                                    <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                        <strong class="ms-3 border rounded p-1 text-white fs-6 bg-info">Đã giao hàng</strong>
                                    </li>
                                    <li> Địa chỉ:
                                        {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                    </li>
                                    <li> Phí vận chuyển: 15,000 vnđ</li>
                                    <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                    </li>
                                </ul>
                                <div class="border p-2 rounded d-flex gap-2">
                                    @foreach ($productOrders as $item)
                                        @if ($item->order_id == $value->order_id && $item->product_variant_id == null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->products->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @elseif($item->order_id == $value->order_id && $item->product_variant_id != null)
                                            <div class="order-item">
                                                <img src="{{ asset($item->product_variants->image) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                                <p class="text-start m-0">
                                                    {{ $item->products->name . ' - ' . $item->product_variants->sku }}</p>
                                                <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                                <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div id="cancelled" class="order-details">
                    @foreach ($orderLists as $value)
                    @if ($value->orders->status == 5)
                        <div class="border p-2 rounded" style="width:100%;">
                            <ul>
                                <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                    <strong class="ms-3 border rounded p-1 text-white fs-6 bg-danger">Đã huỷ</strong>
                                </li>
                                <li> Địa chỉ:
                                    {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                </li>
                                <li> Phí vận chuyển: 15,000 vnđ</li>
                                <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                </li>
                            </ul>
                            <div class="border p-2 rounded d-flex gap-2">
                                @foreach ($productOrders as $item)
                                    @if ($item->order_id == $value->order_id && $item->product_variant_id == null)
                                        <div class="order-item">
                                            <img src="{{ asset($item->products->image) }}"
                                                style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                            <p class="text-start m-0">
                                                {{ $item->products->name }}</p>
                                            <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                            <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                        </div>
                                    @elseif($item->order_id == $value->order_id && $item->product_variant_id != null)
                                        <div class="order-item">
                                            <img src="{{ asset($item->product_variants->image) }}"
                                                style="width: 70px; height: 70px; object-fit: cover;" alt="">
                                            <p class="text-start m-0">
                                                {{ $item->products->name . ' - ' . $item->product_variants->sku }}</p>
                                            <p class="text-start m-0">Số lượng: {{ $item->quantity }} </p>
                                            <p class="text-start m-0">Giá: {{ number_format($item->price) }} vnđ</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
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
            // Lắng nghe sự kiện click
            document.addEventListener("DOMContentLoaded", function() {
                const buttons = document.querySelectorAll(".xemchitiet");

                buttons.forEach((button) => {
                    button.addEventListener("click", function() {
                        const orderProduct = this
                            .nextElementSibling; // Tìm phần tử kế tiếp là .order-product

                        if (orderProduct.style.display === "none" || orderProduct.style.display ===
                            "") {
                            orderProduct.style.display = "block"; // Hiện sản phẩm
                            this.textContent = "Ẩn chi tiết"; // Đổi nội dung nút
                        } else {
                            orderProduct.style.display = "none"; // Ẩn sản phẩm
                            this.textContent = "Xem chi tiết"; // Đổi lại nội dung nút
                        }
                    });
                });
            });

            function toggleOrderDetails(status) {
                // Ẩn tất cả các chi tiết đơn hàng
                const allDetails = document.querySelectorAll('.order-details');
                allDetails.forEach(detail => {
                    detail.style.display = 'none';
                });

                // Hiển thị chi tiết đơn hàng tương ứng
                const selectedDetails = document.getElementById(status);
                selectedDetails.style.display = 'block';

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
