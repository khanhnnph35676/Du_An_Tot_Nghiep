@extends('user.layout.default')
@push('styleStore')
    <style>
        .features-section {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: #f8f8f8;
        }

        .feature {
            text-align: center;
            max-width: 200px;
        }

        .feature img {
            width: 50px;
            margin-bottom: 10px;
        }

        .feature p {
            font-weight: bold;
            margin: 5px 0;
        }

        .feature span {
            color: #666;
            font-size: 14px;

        }
    </style>
@endpush
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Giới thiệu</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li c lass="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>/
            <li class="ms-1 breadcrumb-item active text-white"> Giới thiệu</li>
        </ol>
    </div>

    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-6">
                <h3>Giới thiệu về SnackFood</h3>
                <h6>Gợi ý tất cả các loại đồ ăn vặt của bạn</h6>
                <a href="#" class="shop-button">Shop Now
                    <svg class="ml-2 icon-button-base" xmlns="http://www.w3.org/svg" width="10" height="8"
                        viewBox="0 0 10 8" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9 4.50012H0V3.50012H9V4.50012Z"
                            fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 4.50012L5.99999 1.50008L6.70709 0.792969L9.70709 3.79297L9 4.50012Z" fill="currentColor">
                        </path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 3.50012L5.99999 6.50017L6.70709 7.20728L9.70709 4.20728L9 3.50012Z" fill="currentColor">
                        </path>
                    </svg>
                </a>
            </div>
            <div class="col-6 text-end">
                <img src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/ee8a61200750313.66680beb3d48b.jpg"
                    alt="Main Image" class="main-image" style="width: 100%; object-fit: cover;">
            </div>
        </div>
        <!-- Section 1 -->
        <div class="row" style="max-height:400px;">
            <div class="col-6">
                <img src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/9fd15a185094509.655dc7178246f.jpg"
                    alt="Ice cream image 1" style="width: 100%; height:50%; object-fit: cover;">
            </div>
            <div class="col-6">
                <h3>Ưu Đãi Đặc Biệt Mua 1 Tặng 1</h3>
                <p>SnF còn mang đến chương trình MUA 1 TẶNG 1 cực sốc. Khi bạn mua Combo Bánh tráng</p>
            </div>
        </div>
    </div>
    <section class="features-section text-center py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 mb-3">
                    <i class="fa-solid fa-truck fa-2x"></i>
                    <p>Miễn phí vận chuyển</p>
                    <span>Từ tất cả các đơn đặt hàng trên 100.000 Vnđ</span>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <i class="fa-solid fa-phone-volume fa-2x"></i>
                    <p>Hỗ trợ chất lượng</p>
                    <span>Phản hồi trực tuyến 24/7</span>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <i class="fa-solid fa-right-left fa-2x"></i>
                    <p>Trả lại & Hoàn tiền</p>
                    <span>Trả lại tiền trong vòng 7 ngày</span>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <i class="fa-solid fa-ticket fa-2x"></i>
                    <p>Phiếu quà tặng</p>
                    <span>Giảm giá 20% khi bạn mua sắm trực tuyến</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scriptHome')
@endpush
