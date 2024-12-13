@extends('user.layout.default')

@push('styleStore')
@endpush

@section('content')
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
            padding: 5px 10px;
            border-radius: 0px;
            background-color: #fff;
            flex-grow: 1;
            text-align: center;
            margin: 5px
        }

        .status-title:hover {
            background-color: #daddd4c7;
        }

        .content-order {
            overflow: auto;
            max-height: 600px;
            /* background: #007bff; */
        }

        .content-order::-webkit-scrollbar {
            width: 3px;
            /* Độ rộng thanh cuộn */
        }

        .content-order::-webkit-scrollbar-thumb {
            background: #888;
            /* Màu của thanh cuộn */
            border-radius: 4px;
            /* Bo góc cho thanh cuộn */
        }

        .content-order::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Màu khi hover */
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

        .order-items-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        #order-items {
            display: flex;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
        }

        .order-item {
            flex: 0 0 auto;
            scroll-snap-align: start;
            margin-right: 10px;
        }

        .order-items-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 10;
        }

        button {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }

        button:disabled {
            background: rgba(0, 0, 0, 0.2);
        }

        .huy:hover {
            background: rgba(249, 0, 0, 0.337);
            color: white;
        }

        .status-title {
            color: #333;
        }

        .danhgia:hover {
            background: rgba(5, 220, 5, 0.687)
        }
    </style>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang Chủ</a></li>
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
            <div class="col-lg-3">
                <ul class="side-bar border rounded p-1">
                    <h3 class="mb-4 mt-3 ms-3">Đơn Hàng</h3>
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
                <!-- Menu trạng thái đơn hàng -->
                <div class="order-status-menu">
                    <div class="status-title border rounded" onclick="toggleOrderDetails('tatca')">Tất cả</div>
                    <div class="status-title border rounded" onclick="toggleOrderDetails('pending')">Chờ Xác Nhận</div>
                    <div class="status-title border rounded" onclick="toggleOrderDetails('awaiting')">Chờ Lấy Hàng</div>
                    <div class="status-title border rounded" onclick="toggleOrderDetails('shipping')">Chờ Giao Hàng</div>
                    <div class="status-title border rounded" onclick="toggleOrderDetails('delivered')">Đã Giao</div>
                    <div class="status-title border rounded" onclick="toggleOrderDetails('cancelled')">Đã Hủy</div>
                </div>
                <div class="content-order">
                    {{-- tất cả order --}}
                    <div id="tatca" class="order-details">
                        @foreach ($orderLists as $value)
                            <div class="border p-2 rounded border mb-2 d-flex justify-content-between" style="width:100%;">
                                <a href="{{ route('order.detail',['order_id' =>$value->order_id]) }}" class="text-dark">
                                    <ul>
                                        <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                            @if ($value->orders->status == 1)
                                                <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-white">Chờ Xác
                                                    Nhận</strong>
                                            @elseif($value->orders->status == 2)
                                                <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-secondary">Chờ Lấy
                                                    Hàng</strong>
                                            @elseif($value->orders->status == 3)
                                                <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-info">Đang Giao
                                                    Hàng</strong>
                                            @elseif($value->orders->status == 4)
                                                <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-primary">Đã Giao
                                                    Hàng</strong>
                                            @elseif($value->orders->status == 5)
                                                <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-danger">Đã
                                                    Huỷ</strong>
                                            @endif

                                        </li>
                                        <li> Địa chỉ:
                                            {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                        </li>
                                        <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                        </li>
                                    </ul>
                                </a>

                                @if ($value->orders->status == 1)
                                    <form action="{{ route('destroyOrder') }}" class="mt-3 text-end" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="text" value="{{ $value->orders->id }}" name='order_id' hidden>
                                        <button class="huy btn btn border me-2">Huỷ đơn</button>
                                    </form>
                                @elseif($value->orders->status == 4)
                                    <form action="" class="mt-3 text-end" method="POST">
                                        @csrf
                                        <input type="text" value="{{ $value->orders->id }}" name='order_id' hidden>
                                        <button class="danhgia btn btn-primary border me-2">Đánh giá</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    {{-- chờ xác nhận --}}
                    <div id="pending" class="order-details">
                        @foreach ($orderLists as $value)
                            @if ($value->orders->status == 1)
                                <div class="border p-2 rounded border mb-2 d-flex justify-content-between"
                                    style="width:100%;">
                                    <ul>
                                        <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                            <strong class="ms-3 border rounded p-1 text-dark fs-6 bg-white">Chờ Xác
                                                Nhận</strong>
                                        </li>
                                        <li> Địa chỉ:
                                            {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                        </li>
                                        <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                        </li>
                                    </ul>

                                    <form action="{{ route('destroyOrder') }}" class="mt-3 text-end" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="text" value="{{ $value->orders->id }}" name='order_id' hidden>
                                        <button class="huy btn btn border me-2">Huỷ đơn</button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    {{-- Chờ lấy hàng --}}
                    <div id="awaiting" class="order-details">
                        @foreach ($orderLists as $value)
                            @if ($value->orders->status == 2)
                                <div class="border p-2 rounded mb-2" style="width:100%;">
                                    <ul>
                                        <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                            <strong class="ms-3 border rounded p-1 text-white fs-6 bg-secondary">Chờ Lấy
                                                Hàng</strong>
                                        </li>
                                        <li> Địa chỉ:
                                            {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                        </li>

                                        <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    {{-- Chờ giao hàng --}}
                    <div id="shipping" class="order-details">
                        @foreach ($orderLists as $value)
                            @if ($value->orders->status == 3)
                                <div class="border p-2 rounded mb-2" style="width:100%;">
                                    <ul>
                                        <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                            <strong class="ms-3 border rounded p-1 text-white fs-6 bg-info">Đang giao
                                                hàng</strong>
                                        </li>
                                        <li> Địa chỉ:
                                            {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                        </li>

                                        <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    {{-- Đã giao hàng --}}
                    <div id="delivered" class="order-details">
                        @foreach ($orderLists as $value)
                            @if ($value->orders->status == 4)
                                <div class="border p-2 rounded mb-2 d-flex justify-content-between" style="width:100%;">
                                    <ul class="me-5">
                                        <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                            <strong class="ms-3 border rounded p-1 text-white fs-6 bg-primary">Đã giao
                                                hàng</strong>
                                        </li>
                                        <li> Địa chỉ:
                                            {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                        </li>

                                        <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                        </li>
                                    </ul>
                                    <form action="" class="mt-3 text-end" method="POST">
                                        @csrf
                                        <input type="text" value="{{ $value->orders->id }}" name='order_id' hidden>
                                        <button class="danhgia btn btn-primary border me-2">Đánh giá</button>
                                    </form>

                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div id="cancelled" class="order-details">
                        @foreach ($orderLists as $value)
                            @if ($value->orders->status == 5)
                                <div class="border p-2 rounded mb-2" style="width:100%;">
                                    <ul>
                                        <li> Mã đơn hàng: {{ $value->orders->order_code }}
                                            <strong class="ms-3 border rounded p-1 text-white fs-6 bg-danger">Đã
                                                huỷ</strong>
                                        </li>
                                        <li> Địa chỉ:
                                            {{ isset($value->orders->address) ? $value->orders->address->home_address . ', ' . $value->orders->address->address : 'Chưa có địa chỉ' }}
                                        </li>

                                        <li> <strong> Tổng giá: {{ number_format($value->orders->sum_price) }} vnđ</strong>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- Chi tiết đơn hàng -->
            </div>
        </div>
    </div>
    <!-- Order History End -->

    @push('scriptStore')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Kích hoạt sự kiện click vào nút "Tất cả"
                const allButton = document.querySelector('.status-title[onclick="toggleOrderDetails(\'tatca\')"]');
                if (allButton) {
                    allButton.click();
                }
            });
            $('.status-title').on('click', function() {
                $('.status-title').css('color', '#333');
                $('.status-title').css('border-bottom', 'none');
                $('.status-title').css('background-color', '#fff');
                $(this).css('background-color', '#FFA500');
                $(this).css('color', 'white');
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
            // nút di chuyển
            document.addEventListener('DOMContentLoaded', function() {
                const itemsContainer = document.getElementById('order-items');
                const prevBtn = document.getElementById('prev-btn');
                const nextBtn = document.getElementById('next-btn');
                const controls = document.getElementById('order-items-controls');

                const visibleItemsCount = 5;

                // Đo chiều rộng của một item (bao gồm margin)
                const itemWidth = itemsContainer.children[0].offsetWidth + parseInt(window.getComputedStyle(
                    itemsContainer.children[0]).marginRight);

                const totalItemsCount = itemsContainer.children.length;

                // Nếu có hơn 5 sản phẩm, hiển thị các nút di chuyển
                if (totalItemsCount > visibleItemsCount) {
                    controls.style.display = 'flex';
                }

                // Tính toán vị trí cuộn tối đa
                const maxScrollPosition = (totalItemsCount - visibleItemsCount) * itemWidth;

                // Hàm cập nhật trạng thái nút (kiểm tra vị trí cuộn hiện tại)
                function updateButtonState() {
                    const currentPosition = itemsContainer.scrollLeft;
                    prevBtn.disabled = currentPosition <= 0;
                    nextBtn.disabled = currentPosition >= maxScrollPosition;
                }

                // Thêm sự kiện cho nút cuộn qua phải
                nextBtn.addEventListener('click', function() {
                    itemsContainer.scrollLeft += itemWidth; // Di chuyển qua phải
                    updateButtonState();
                });

                // Thêm sự kiện cho nút cuộn qua trái
                prevBtn.addEventListener('click', function() {
                    itemsContainer.scrollLeft -= itemWidth; // Di chuyển qua trái
                    updateButtonState();
                });

                // Cập nhật trạng thái nút khi trang web load
                updateButtonState();
            });
        </script>
    @endpush
@endsection
