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
        font-size: 18px;
        padding: 10px 15px;
        border-radius: 0px;
        background-color: #fff;
        transition: background-color 0.3s;
        flex-grow: 1; /* Để các mục có chiều rộng bằng nhau */
        text-align: center; /* Canh giữa nội dung */
        border: 1px solid #81C408; /* Viền cho trạng thái đơn hàng */
    }
    .status-title:hover {
        background-color: #81C408;
    }
    .order-details {
        display: none; /* Ẩn chi tiết đơn hàng mặc định */
        flex-wrap: wrap; /* Cho phép các mục con xuống hàng */
        gap: 15px; /* Khoảng cách giữa các mục con */
        margin-top: 15px;
        
    }
    .order-item {
        padding: 10px;
        border: 1px solid #81C408; /* Viền cho đơn hàng */
        border-radius: 8px;
        background-color: #f9f9f9;
        width: calc(25% - 15px); /* Chiều rộng của mỗi mục */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        
    }
    .order-item .order-id {
        font-weight: bold;
        
        border-radius: 5%;
        padding: 5px;
        background-color: #fff; /* Nền cho mã đơn hàng */
        margin-top: 10px; /* Khoảng cách giữa ảnh và mã đơn hàng */
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

                <!-- Chi tiết đơn hàng -->
                <div id="pending" class="order-details">
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 1">
                        <span class="status-title">Đơn Hàng #12345</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>  
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 2">
                        <span class="status-title">Đơn Hàng #12351</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>
                </div>

                <div id="awaiting" class="order-details">
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 3">
                        <span class="status-title">Đơn Hàng #12346</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>
                </div>

                <div id="shipping" class="order-details">
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 4">
                        <span class="status-title">Đơn Hàng #12347</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>
                </div>

                <div id="delivered" class="order-details">
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 5">
                        <span class="status-title">Đơn Hàng #12348</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 6">
                        <span class="status-title">Đơn Hàng #12349</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>
                </div>

                <div id="cancelled" class="order-details">
                    <div class="order-item">
                        <img src="https://via.placeholder.com/150" alt="Sản phẩm 7">
                        <span class="status-title">Đơn Hàng #12350</span>
                        <a href="#" class="view-details">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order History End -->

    @push('scriptStore')
    <script>
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
