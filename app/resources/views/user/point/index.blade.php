@extends('user.layout.default')
@push('styleStore')
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .info-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-edit {
            margin-top: 20px;
            width: 100%;
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
        .qty-point{
            position: absolute;
            right: 0;
            width: auto;
            height: auto;
            text-align: center;
            z-index: 1;
            opacity: 0.7;
        }
        .point{
            font-size: 100px;
            color: #333;
        }
        .title-point{
            font-size: 20px;
            color: #333;
        }
    </style>
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Điểm thưởng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Điểm thưởng</li>
        </ol>
    </div>
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
    <!-- Single Page Header End -->
    <div class="container py-5">
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
            <div class="col-lg-8 m-0 p-0 ms-4">
                <div class="row">
                    <div class="col-lg-8 border rounded p-2 mb-3 me-3">
                        <h3 class="m-3"> Phiếu giảm giá </h3>
                        <div class="d-flex flex-wrap justify-content-start gap-3 m-2">
                            <!-- Card 1 -->
                            <div class="card shadow-sm rounded-3" style="width: 31%;">
                                <span class="qty-point border bg-secondary text-white p-1">x3111</span>
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success mb-3 text-start">Mã giảm giá </h5>
                                    <p class="text-start">Miễn phí vận chuyển</p>
                                    <p class="text-start">Miễn phí vận chuyển</p>
                                    <div class="text-end">
                                        <a href="#" class="btn btn-primary">Đổi ngay</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-sm rounded-3" style="width: 31%;">
                                <span class="qty-point border bg-secondary text-white">x3</span>
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success mb-3 text-start">Giảm giá </h5>
                                    <p class="card-text text-start">Nhận ngay <strong></strong> cho đơn hàng tiếp theo của bạn.</p>
                                    <p>Miễn phí vận chuyển</p>
                                    <div class="text-end">
                                        <a href="#" class="btn btn-primary">Đổi ngay</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-sm rounded-3" style="width: 31%;">
                                <span class="qty-point border bg-secondary text-white">x3</span>
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success mb-3 text-start">Giảm giá </h5>
                                    <p class="card-text text-start">Nhận ngay <strong></strong> cho đơn hàng tiếp theo của bạn.</p>
                                    <p>Miễn phí vận chuyển</p>
                                    <div class="text-end">
                                        <a href="#" class="btn btn-primary">Đổi ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 border p-2 mb-3 rounded" >
                        <h5 class="m-2 text-center">
                             <span class="me-3 title-point"> Điểm thưởng </span>
                        </h5>
                        <div class="d-flex border rounded justify-content-center align-items-start">

                            <div class="text-center point">90</div>
                            <img src="{{asset("img/xu.png")}}"  style="width: 60px; height: 60px; object-fit: cover;" alt="">
                        </div>

                        {{-- <button class="btn btn-primary">Nhận thêm</button> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scriptStore')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
@endpush
