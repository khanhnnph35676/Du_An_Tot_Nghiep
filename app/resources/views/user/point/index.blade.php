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

        .qty-point {
            position: absolute;
            right: 0;
            width: auto;
            height: auto;
            text-align: center;
            z-index: 1;
            opacity: 0.7;
        }

        .point {
            font-size: 29px;
            color: #333;
        }

        .title-point {
            font-size: 20px;
            color: #333;
        }

        .redeem {
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .name-voucher {
            font-size: 13px;
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
        @if (session('error'))
            <div class="error">
                <div class="alert alert-danger alert-dismissible alert-alt solid fade show">
                    @if (session('error'))
                        <strong>{{ session('error') }}</strong>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-3">
                <ul class="side-bar border rounded p-1">
                    <h3 class="mb-4 mt-3 ms-3">Điểm thưởng</h3>
                    <li class="p-2 mt-2"><a href="{{ route('user.profile') }}" class="text-dark"><strong>Thông tin cá
                                nhân</strong> </a> </li>

                    <li class="p-2 mt-2"><a href="{{ route('order.history') }}" class="text-dark"><strong>Đơn hàng
                                ({{ $count }})</strong>
                        </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('points') }}" class="text-dark"><strong>Điểm thưởng</strong>
                        </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('user.change-password') }}" class="text-dark"><strong>Đổi mật khẩu</strong>
                        </a> </li>
                </ul>
            </div>
            <div class="col-lg-8 m-0 p-0 ms-4">
                <div class="row">
                    <div class="col-lg-8 border rounded p-2 mb-3 me-3">
                        <h3 class="m-3"> Phiếu giảm giá </h3>
                        <form id="voucherForm" action="{{ route('addVoucher') }}" method="POST">
                            @csrf
                            <!-- Input ẩn giữ giá trị voucher_id được chọn -->
                            <input type="hidden" id="voucher_id" name="voucher_id" value="">

                            <div class="d-flex flex-wrap justify-content-start gap-3 m-2">
                                <!-- Vòng lặp hiển thị các voucher -->
                                @foreach ($listVouchers as $voucher)
                                    <div class="card shadow-sm rounded-3" style="width: 31%; min-height:200px;">
                                        <span class="qty-point border bg-secondary text-white p-1 d-flex">
                                            @if ($user_voucher == [])
                                                x0
                                            @else
                                                @foreach ($user_voucher as $value)
                                                    @if ($value->voucher_id == $voucher->id)
                                                        x{{ $value->qty }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </span>
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-success mb-3 text-start">Mã:
                                                {{ $voucher->code_vocher }}
                                            </h6>
                                            <p class="text-start name-voucher">{{ $voucher->name }}</p>
                                            <p style="font-size: 10px;">HSD: {{' đến '.\Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y')   }}</p>
                                            <!-- Nút để chọn voucher -->
                                            <button type="button" class="btn btn-primary redeem m-2"
                                                onclick="setVoucherAndSubmit('{{ $voucher->id }}')">
                                                <div class="d-flex justify-content-start align-items-start group-point">
                                                    <div class="text-center">{{ $voucher->point }}</div>
                                                    <img src="{{ asset('img/xu.png') }}"
                                                        style="width: 20px; height: 20px; object-fit: cover;"
                                                        alt="">
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-3 border p-2 mb-3 rounded">
                        <h5 class="m-2 text-start">
                            <span class="me-3 title-point">Xu của tôi</span>
                        </h5>
                        <div class="d-flex border rounded justify-content-strat align-items-start group-point me-4">
                            <div class="text-center point ms-2">{{ $point->point ?? '0' }}</div>
                            <img src="{{ asset('img/xu.png') }}" style="width: 20px; height: 20px; object-fit: cover;"
                                alt="">
                        </div>

                        {{-- <button class="btn btn-primary">Nhận thêm</button> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function setVoucherAndSubmit(voucherId) {
            // Gán giá trị voucher_id vào input ẩn
            document.getElementById('voucher_id').value = voucherId;

            // Submit form
            document.getElementById('voucherForm').submit();
        }
    </script>
@endsection

@push('scriptStore')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
@endpush
