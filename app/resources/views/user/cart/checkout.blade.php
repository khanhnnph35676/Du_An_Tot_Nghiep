@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
    <style>
        .table,
        .label {
            color: black;
        }

        input:not(:placeholder-shown) {
            color: black;
        }

        .form-control:focus {
            color: black;
            box-shadow: 0 0 5px rgba(255, 87, 34, 0.5);
            /* Hiệu ứng đổ bóng */
        }

        .wrapper {
            height: 100vh;
            width: 100%;
            background: #00000044;
            position: fixed;
            top: 0;
            z-index: 1;
        }

        .mess-checkout {
            width: 400px;
            height: 220px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2 !important;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            /* Tùy chọn để tạo bo góc */
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

        .card.selected {
            border: 2px solid #1eff00;
            /* Đổi màu viền voucher được chọn */
            background-color: #eaf4ff;
            /* Làm nền sáng để phân biệt */
        }

        .redeem {
            background-color: #2cdb1599;
            /* Màu xanh mặc định */
            color: white;
            border: none;
            transition: background-color 0.3s ease;
            /* Hiệu ứng mượt */
        }

        .redeem.used {
            background-color: #6c757d;
            /* Màu xám khi đã dùng */
            color: #fff;
        }


        #price {
            border: none;
            /* Ẩn viền */
            background: none;
            /* Loại bỏ nền */
            color: inherit;
            /* Giữ màu chữ theo bối cảnh */
            outline: none;
            /* Ẩn viền khi focus */
            pointer-events: none;
            /* Không cho phép click hoặc chỉnh sửa */
        }
    </style>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thanh toán</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item text-white"><a href="{{ route('storeListCart') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active text-white">Thanh toán</li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    @php
        // print_r($checkOrder);
        //  print_r($mesOrder);
    @endphp
    {{-- @if ($checkOrder != null)
        @foreach ($checkOrder as $item)
            @if ($item['payment_id'] == 2)
                <div class="mess-checkout border">
                    <div class="content text-center text-dark fs-5 mt-3">
                        Bạn đã huỷ thanh toán bằng Momo. Hệ thống sẽ tự chuyển cho bạn sang thanh toán COD
                    </div>
                    <div class="d-flex mt-5 justify-content-end">
                        <a href="{{ route('successCheckout') }}" class="btn btn border me-4">Huỷ</a>
                        <form action="{{route('payMomo')}}" method="POST">
                            @csrf
                            <button class="btn btn-primary me-3">Tiếp tục thanh toán </button>
                        </form>
                    </div>
                </div>
                <div class="wrapper">
                </div>
            @endif
        @endforeach
    @endif --}}


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-3 rounded border">
            <h1 class="mb-4">Thanh toán</h1>
            <form action="{{ route('AddOrder') }}" method="POST">
                @csrf
                @if (!Auth::check())
                    <input type="text" name='pass' value="abc123" hidden>
                @endif
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="form-item">
                                <label class="form-label my-3">Họ tên<sup>*</sup></label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}" placeholder="Họ tên">
                            </div>
                            @error('name')
                                <div class="alert alert-danger p-2 mt-1"><strong>Lỗi!</strong> {{ $message }}
                                </div>
                            @enderror
                            {{-- @error('error')
                            <div class="alert alert-danger p-2 mt-1"><strong>Lỗi!</strong> {{ $message }}
                            </div>
                        @enderror --}}

                        </div>
                        @php
                            // print_r($addresses);
                            // print_r($address);
                            // print_r($cart);
                            $countAddresses = 0;
                            $address_id = null;
                        @endphp
                        @if ($address)
                            @foreach ($address as $key => $item)
                                <div class="row address-item" id="address-row-{{ $item->id }}">
                                    <div class="form-item  align-items-center">
                                        <br>
                                        @if ($item->user_id != null)
                                            <span class="form-label my-3">Địa chỉ {{ $key + 1 }}:<sup>*</sup></span>
                                            <div class="d-flex mt-2">
                                                <input type="radio" name="selected_address"
                                                    id="address-{{ $item->id }}" value="{{ $item->id }}"
                                                    class="me-2" {{ $key === 0 ? 'checked' : '' }}>

                                                <!-- Hiển thị địa chỉ -->
                                                <input type="text" class="form-control me-2" placeholder="Địa chỉ"
                                                    value="{{ $item->home_address . ', ' . $item->address }}" readonly>
                                                <!-- Nút chọn -->
                                                <button class="btn btn-primary select-address me-2" type="button"
                                                    data-id="{{ $item->id }}">Chọn</button>

                                                <!-- Nút xóa -->
                                                <button class="btn btn-danger delete-address" type="button"
                                                    data-id="{{ $item->id }}">Xóa</button>
                                            </div>
                                        @else
                                            @foreach ($addresses as $key2 => $value)
                                                @if ($value['id'] == $item->id)
                                                    <span class="form-label my-3">Địa chỉ
                                                        {{ $key + 1 }}:<sup>*</sup></span>
                                                    <div class="d-flex mt-2">
                                                        <input type="radio" name="selected_address"
                                                            id="address-{{ $item->id }}" value="{{ $item->id }}"
                                                            class="me-2" {{ $key === 0 ? 'checked' : '' }}>

                                                        <!-- Hiển thị địa chỉ -->
                                                        <input type="text" class="form-control me-2"
                                                            placeholder="Địa chỉ"
                                                            value="{{ $item->home_address . ', ' . $item->address }}"
                                                            readonly>
                                                        <!-- Nút chọn -->
                                                        <button class="btn btn-primary select-address me-2" type="button"
                                                            data-id="{{ $item->id }}">Chọn</button>

                                                        <!-- Nút xóa -->
                                                        <button class="btn btn-danger delete-address" type="button"
                                                            data-id="{{ $item->id }}">Xóa</button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                            data-bs-target="#add_address">Thêm địa chỉ mới</button>
                        @error('selected_address')
                            <div class="alert alert-danger p-2 mt-1"><strong>Lỗi!</strong> {{ $message }}
                            </div>
                        @enderror

                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại<sup>*</sup></label>
                            <input type="tel" class="form-control" placeholder="Số điện thoại" name="phone"
                                value="{{ isset(Auth::user()->phone) ? Auth::user()->phone : '' }}">
                            @error('phone')
                                <div class="alert alert-danger p-2 mt-1"><strong>Lỗi!</strong> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Địa chỉ Email<sup>*</sup></label>
                            <input type="email" class="form-control" placeholder="Email" name="email"
                                value="{{ isset(Auth::user()->email) ? Auth::user()->email : '' }}">
                            @error('email')
                                <div class="alert alert-danger p-2 mt-1"><strong>Lỗi!</strong> {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Phương thức thanh toán<sup>*</sup></label>
                            <div class="payment-id">
                                @foreach ($payments as $payment)
                                    <input type="radio" name="payment_id" value="{{ $payment->id }}"
                                        id="payment-{{ $payment->id }}" @if ($payment->id == '1') checked @endif>
                                    <label class="form-label my-3 me-3">{{ $payment->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col" style="min-width:100px;">Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $sumPrice = 0;
                                    @endphp
                                    @if (Auth::check())
                                        @foreach ($products as $product)
                                            @foreach ($cart as $item)
                                                @if (
                                                    $product->id == $item['product_id'] &&
                                                        $product->type == 1 &&
                                                        Auth::id() == $item['user_id'] &&
                                                        $item['selected_products'] == 1)
                                                    @if ($item['discount'] != 0)
                                                        @php
                                                            $sumPrice +=
                                                                ($product->price -
                                                                    ($product->price * $item['discount']) / 100) *
                                                                $item['qty'];
                                                        @endphp
                                                    @else
                                                        @php
                                                            $sumPrice += $product->price * $item['qty'];
                                                        @endphp
                                                    @endif
                                                    <tr class="mt-1 mb-1">
                                                        <th scope="row">
                                                            <div class="d-flex align-items-center">
                                                                <img src=" {{ asset($product->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </div>
                                                        </th>
                                                        <td class="align-middle">
                                                            {{ Str::words(strip_tags($product->name), 6, '...') }}
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($item['discount'] != 0)
                                                                <input type="text" name='price'
                                                                    value="{{ $product->price - ($product->price * $item['discount']) / 100 }}"
                                                                    hidden>
                                                                {{ number_format($product->price - ($product->price * $item['discount']) / 100) . ' Vnđ' }}
                                                            @else
                                                                <input type="text" name='price'
                                                                    value="{{ $product->price }}" hidden>
                                                                {{ number_format($product->price) . ' Vnđ' }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center align-middle">{{ $item['qty'] }}</td>
                                                @endif
                                                @foreach ($productVariants as $productVariant)
                                                    @if (
                                                        $product->id == $item['product_id'] &&
                                                            $item['product_variant_id'] == $productVariant->id &&
                                                            Auth::id() == $item['user_id'] &&
                                                            $item['selected_products'] === 1)
                                                        @if ($item['discount'] != 0)
                                                            @php
                                                                $sumPrice +=
                                                                    ($productVariant->price -
                                                                        ($productVariant->price * $item['discount']) /
                                                                            100) *
                                                                    $item['qty'];
                                                            @endphp
                                                        @else
                                                            @php
                                                                $sumPrice += $productVariant->price * $item['qty'];
                                                            @endphp
                                                        @endif
                                                        <tr>
                                                            <td scope="row">
                                                                <img src="{{ asset($productVariant->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </td>
                                                            <td class="align-middle">
                                                                {{ Str::words(strip_tags($product->name . ' - ' . $productVariant->sku), 6, '...') }}
                                                            </td>
                                                            <td class="align-middle" style="width:100px;">
                                                                @if ($item['discount'] != 0)
                                                                    <input type="text" name='price'
                                                                        value="{{ $productVariant->price - ($productVariant->price * $item['discount']) / 100 }}"
                                                                        hidden>
                                                                    {{ number_format($productVariant->price - ($productVariant->price * $item['discount']) / 100) . ' Vnđ' }}
                                                                @else
                                                                    <input type="text" name='price'
                                                                        value="{{ $productVariant->price }}" hidden>
                                                                    {{ number_format($productVariant->price) . ' Vnđ' }}
                                                                @endif
                                                            </td>
                                                            <td class="text-center align-middle">{{ $item['qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($products as $product)
                                            @foreach ($cart as $item)
                                                @if (
                                                    $product->id == $item['product_id'] &&
                                                        $product->type == 1 &&
                                                        $item['user_id'] == 0 &&
                                                        $item['selected_products'] === 1)
                                                    @if ($item['discount'] != 0)
                                                        @php
                                                            $sumPrice +=
                                                                ($product->price -
                                                                    ($product->price * $item['discount']) / 100) *
                                                                $item['qty'];
                                                        @endphp
                                                    @else
                                                        @php
                                                            $sumPrice += $product->price * $item['qty'];
                                                        @endphp
                                                    @endif
                                                    <tr class="mt-1 mb-1">
                                                        <th scope="row">
                                                            <div class="d-flex align-items-center">
                                                                <img src=" {{ asset($product->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </div>
                                                        </th>
                                                        <td class="align-middle">
                                                            {{ Str::words(strip_tags($product->name), 6, '...') }}
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($item['discount'] != 0)
                                                                <input type="text" name='price'
                                                                    value="{{ $product->price - ($product->price * $item['discount']) / 100 }}"
                                                                    hidden>
                                                                {{ number_format($product->price - ($product->price * $item['discount']) / 100) . ' Vnđ' }}
                                                            @else
                                                                <input type="text" name='price'
                                                                    value="{{ $product->price }}" hidden>
                                                                {{ number_format($product->price) . ' Vnđ' }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center align-middle">{{ $item['qty'] }}</td>
                                                @endif
                                                @foreach ($productVariants as $productVariant)
                                                    @if (
                                                        $product->id == $item['product_id'] &&
                                                            $item['product_variant_id'] == $productVariant->id &&
                                                            $item['user_id'] == 0 &&
                                                            $item['selected_products'] === 1)
                                                        @if ($item['discount'] != 0)
                                                            @php
                                                                $sumPrice +=
                                                                    ($productVariant->price -
                                                                        ($productVariant->price * $item['discount']) /
                                                                            100) *
                                                                    $item['qty'];
                                                            @endphp
                                                        @else
                                                            @php
                                                                $sumPrice += $productVariant->price * $item['qty'];
                                                            @endphp
                                                        @endif
                                                        <tr>
                                                            <td scope="row">
                                                                <img src="{{ asset($productVariant->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </td>
                                                            <td class="align-middle">
                                                                {{ Str::words(strip_tags($product->name . ' - ' . $productVariant->sku), 6, '...') }}
                                                            </td>
                                                            <td class="align-middle" style="width:100px;">
                                                                @if ($item['discount'] != 0)
                                                                    <input type="text" name='price'
                                                                        value="{{ $productVariant->price - ($productVariant->price * $item['discount']) / 100 }}"
                                                                        hidden>
                                                                    {{ number_format($productVariant->price - ($productVariant->price * $item['discount']) / 100) . ' Vnđ' }}
                                                                @else
                                                                    <input type="text" name='price'
                                                                        value="{{ $productVariant->price }}" hidden>
                                                                    {{ number_format($productVariant->price) . ' Vnđ' }}
                                                                @endif
                                                            </td>
                                                            <td class="text-center align-middle">{{ $item['qty'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-3">
                                            <p class="mb-0 py-4">Tổng giá sản phẩm</p>
                                        </td>
                                        <td colspan="3" class="py-3">
                                            <div class="form-check text-start">
                                            </div>
                                            <div class="form-check text-start">
                                                <label class="form-check-label"
                                                    for="Shipping-2">{{ number_format($sumPrice) }} Vnđ</label>
                                            </div>
                                            <div class="form-check text-start">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-3">
                                            <p class="mb-0  py-4">Phí vận chuyển</p>
                                        </td>
                                        <td colspan="3" class="py-3">
                                            <div class="form-check text-start">
                                            </div>
                                            <div class="form-check text-start">
                                                <label class="form-check-label" for="Shipping-2">15.000 Vnđ</label>
                                            </div>
                                            <div class="form-check text-start">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2"></td>
                                        <td class="py-2">
                                            <p class="mb-0 py-4">Tính tiền</p>
                                        </td>
                                        <td colspan="3" class="py-2">
                                            <div class="form-check text-start">
                                            </div>
                                            <div class="form-check text-start">
                                                @php
                                                    $sumPrice += 15000;
                                                @endphp
                                                <span id="total-price">{{ number_format($sumPrice) }} Vnđ</span>
                                                <input type="text" name='sum_price' value="{{ $sumPrice }}"
                                                    hidden>
                                            </div>
                                            <div class="form-check text-start">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2"></td>
                                        <td class="py-2">
                                            <p class="mb-0 py-4">Điểm nhận được</p>
                                        </td>
                                        <td colspan="3" class="py-2">
                                            <div class="form-check text-start">
                                            </div>
                                            <div class="form-check text-start">
                                                <label class="form-check-label d-flex align-items-start" for="Shipping-2">
                                                    <p class="text-dark fs-4 fw-bold">{{ ceil($sumPrice / 1000) }}</p>
                                                    <img src="{{ asset('img/xu.png') }}" class="me-2"
                                                        style="width: 28px; height: 28px; object-fit: cover;"
                                                        alt="">
                                                </label>
                                            </div>
                                            <div class="form-check text-start">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if (session('error'))
                            <div class="error">
                                <div class="alert alert-danger alert-dismissible alert-alt solid fade show">
                                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    @if (session('error'))
                                        <strong>{{ session('error') }}</strong>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @php
                            // print_r($cart);
                        @endphp
                        <div id="payment-button">
                            <!-- Mặc định hiển thị cho COD -->

                            <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">
                                Thanh toán COD
                            </button>
                        </div>
                        <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" id='momoPayment'
                            style="display:none;">
                            Thanh toán qua ATM Momo
                        </button>
                        <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" name='redirect'
                            id='VNPayment' style="display:none;">
                            Thanh toán qua VNPAY
                        </button>
                        @error('payment_id')
                            <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row mt-3 ms-1">
                        <input id="voucher_id" name="voucher_id" value="" hidden> <!-- Giá hiện tại -->
                        <input id="voucher_sale" name="voucher_sale" value="" hidden>
                        @if (Auth::check())
                            @php
                                // print_r($user_voucher);
                            @endphp
                            <div class="col-lg-12">
                                <div class="border rounded p-2 mb-3">
                                    <h3 class="m-3"> Phiếu giảm giá của tôi</h3>
                                    <div class="d-flex flex-wrap justify-content-start gap-3 m-2">
                                        @foreach ($user_voucher as $voucher)
                                            {{-- @php
                                                   print_r($voucher->voucher);
                                            @endphp --}}
                                            @if (
                                                \Carbon\Carbon::parse(now())->format('d/m/Y') <
                                                    \Carbon\Carbon::parse($voucher->voucher->end_date)->format('d/m/Y') && $sumPrice >= $voucher->voucher->id)
                                                <div class="card shadow-sm rounded-3"
                                                    id="voucher-{{ $voucher->voucher->id }}"
                                                    data-sale="{{ $voucher->voucher->sale }}"
                                                    data-id="{{ $voucher->voucher->id }}"
                                                    style="width: 190px; min-height: 200px;">
                                                    <span class="qty-point border bg-secondary text-white p-1 d-flex">
                                                        @if ($user_voucher == [])
                                                            x0
                                                        @else
                                                            @if ($voucher->voucher_id == $voucher->voucher->id)
                                                                x{{ $voucher->qty }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <div class="card-body text-center">
                                                        <h6 class="card-title text-success mb-3 text-start">Mã:
                                                            {{ $voucher->code_vocher }}</h6>
                                                        <p class="text-start name-voucher">{{ $voucher->voucher->name }}</p>
                                                        <p style="font-size: 10px;">HSD: đến
                                                            {{ \Carbon\Carbon::parse($voucher->voucher->end_date)->format('d/m/Y') }}
                                                        </p>
                                                        <button type="button" class="btn btn-primary redeem m-2"
                                                            onclick="setVoucherAndSubmit('{{ $voucher->voucher->id }}')">
                                                            <div
                                                                class="d-flex justify-content-start align-items-start group-point">
                                                                <div class="text-center">Dùng</div>
                                                            </div>
                                                        </button>

                                                    </div>
                                                </div>
                                            @else
                                                Không có mã giảm giá
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                                Điểm của tôi: {{ $point->point ?? '0' }}
                                <img src="{{ asset('img/xu.png') }}"
                                    style="width: 20px; height: 20px; object-fit: cover;" alt="">
                            </div>
                        @endif
                    </div>
            </form>
        </div>
    </div>

    </div>
    </div>
    <!-- Checkout Page End -->
    <!-- Thêm địa chỉ -->
    <div class="modal fade" id="add_address" tabindex="-1" aria-labelledby="addAddressModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addAddressModel">Thêm mới địa chi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="address-form">
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <label class="form-label my-3">Tỉnh/Thành phố<sup>*</sup></label>
                                    <select name="province" id="province" class="form-control"></select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label class="form-label my-3">Quận/Huyện<sup>*</sup></label>
                                    <select name="district" id="district" class="form-control"></select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label class="form-label my-3">Xã/Phường<sup>*</sup></label>
                                    <select name="ward" id="ward" class="form-control"></select>
                                </div>
                                <div class="col-md-12 col-lg-8">
                                    <label class="form-label my-3">Địa chỉ nhà:<sup>*</sup></label>
                                    <div class="form-item w-100 d-flex">
                                        <input type="text" class="form-control me-2" placeholder="Địa chỉ"
                                            name="home_address" id="home_address">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button id="save-address" type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function setVoucherAndSubmit(voucherId) {
            // Lấy thông tin từ phần tử voucher
            const voucherElement = document.getElementById(`voucher-${voucherId}`);
            const voucherSale = voucherElement.getAttribute('data-sale'); // Lấy giá trị sale
            const voucherButton = voucherElement.querySelector('.redeem'); // Nút "Dùng"

            // Cập nhật giá trị vào các input ẩn
            const voucherIdInput = document.getElementById('voucher_id');
            const voucherSaleInput = document.getElementById('voucher_sale');
            const totalPriceElement = document.getElementById('total-price'); // Element chứa giá trị tổng

            // Định nghĩa giá ban đầu
            let sumPrice = {{ $sumPrice }}; // Assuming $sumPrice is the initial total price

            // Định dạng số
            const formatNumber = (number) => {
                return new Intl.NumberFormat('vi-VN').format(number); // Format to Vietnamese currency style
            };

            // Kiểm tra nếu nút đang ở trạng thái "đã dùng"
            if (voucherButton.classList.contains('used')) {
                // Hủy chọn voucher
                voucherButton.classList.remove('used'); // Xóa trạng thái "đã dùng"
                voucherIdInput.value = ''; // Xóa giá trị voucher_id
                voucherSaleInput.value = ''; // Xóa giá trị voucher_sale
                totalPriceElement.textContent = `${formatNumber(sumPrice)} Vnđ`; // Hiển thị lại giá ban đầu
            } else {
                // Đánh dấu nút hiện tại là "đã dùng" và bỏ chọn các nút khác
                const allButtons = document.querySelectorAll('.redeem');
                allButtons.forEach(button => button.classList.remove('used')); // Xóa trạng thái khỏi nút khác
                voucherButton.classList.add('used'); // Đánh dấu nút hiện tại là "đã dùng"

                // Gán giá trị vào các input
                voucherIdInput.value = voucherId;
                voucherSaleInput.value = voucherSale;

                // Tính toán giá sau khi áp dụng voucher
                let finalPrice = sumPrice;

                // Nếu voucher có sale là 0, giảm 15000
                if (voucherSale == 0) {
                    finalPrice = sumPrice - 15000;
                } else {
                    // Nếu có sale, tính theo phần trăm giảm giá
                    finalPrice = sumPrice - (sumPrice * (voucherSale / 100));
                }

                // Cập nhật lại giá trị vào element tổng tiền
                totalPriceElement.textContent = `${formatNumber(finalPrice.toFixed(0))} Vnđ`;
            }

            // Hiển thị giá trị trong console (Debug)
            console.log('Voucher ID:', voucherIdInput.value);
            console.log('Voucher Sale:', voucherSaleInput.value);
            console.log('Final Price:', totalPriceElement.textContent);
        }
    </script>
    <script>
        // Khai báo đối tượng lưu tên các tỉnh, quận, xã
        let provinceList = {};
        let districtList = {};
        let wardList = {};
        // Lấy danh sách tỉnh/thành phố
        fetch('https://provinces.open-api.vn/api/p/')
            .then(response => response.json())
            .then(data => {
                let provinceSelect = document.getElementById('province');
                provinceSelect.innerHTML = '<option value="">Chọn Tỉnh/Thành phố</option>';
                data.forEach(province => {
                    provinceList[province.code] = province.name; // Lưu tên tỉnh
                    let option = document.createElement('option');
                    option.value = province.code;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
            });

        // Khi chọn tỉnh/thành phố, lấy danh sách quận/huyện
        document.getElementById('province').addEventListener('change', function() {
            let provinceCode = this.value;
            if (provinceCode) {
                fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                    .then(response => response.json())
                    .then(data => {
                        let districtSelect = document.getElementById('district');
                        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                        data.districts.forEach(district => {
                            districtList[district.code] = district.name; // Lưu tên quận
                            let option = document.createElement('option');
                            option.value = district.code;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });

                        // Xóa danh sách xã/phường
                        document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
                    });
            } else {
                // Xóa các danh sách khi không chọn tỉnh/thành phố
                document.getElementById('district').innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
            }
        });
        // Khi chọn quận/huyện, lấy danh sách xã/phường
        document.getElementById('district').addEventListener('change', function() {
            let districtCode = this.value;
            if (districtCode) {
                fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => response.json())
                    .then(data => {
                        let wardSelect = document.getElementById('ward');
                        wardSelect.innerHTML = '<option value="">Chọn Xã/Phường</option>';
                        data.wards.forEach(ward => {
                            wardList[ward.code] = ward.name; // Lưu tên xã
                            let option = document.createElement('option');
                            option.value = ward.code;
                            option.textContent = ward.name;
                            wardSelect.appendChild(option);
                        });
                    });
            } else {
                // Xóa danh sách xã/phường khi không chọn quận/huyện
                document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
            }
        });
        // Khi lưu địa chỉ, thay mã bằng tên
        document.getElementById('save-address').addEventListener('click', function(e) {
            e.preventDefault();
            const provinceCode = document.getElementById('province').value;
            const districtCode = document.getElementById('district').value;
            const wardCode = document.getElementById('ward').value;
            const homeAddress = document.getElementById('home_address').value;

            // Lấy tên tỉnh, quận, xã từ mã đã lưu
            const provinceName = provinceList[provinceCode];
            const districtName = districtList[districtCode];
            const wardName = wardList[wardCode];

            fetch('/address', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: JSON.stringify({
                        province: provinceName,
                        district: districtName,
                        ward: wardName,
                        home_address: homeAddress,
                    }),
                })
                .then((response) => response.json())
                .then(location.reload())

        });
        // Xóa địa chỉ khi nhấn nút "Xóa"
        document.querySelectorAll('.delete-address').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn trình duyệt reload lại trang

                const addressId = this.getAttribute('data-id'); // Lấy ID của địa chỉ
                const addressRow = document.getElementById(
                    `address-row-${addressId}`); // Tìm hàng tương ứng

                // Xóa hàng khỏi DOM
                if (addressRow) {
                    addressRow.remove();
                }

                // Nếu tất cả địa chỉ bị xóa, có thể hiển thị thông báo
                const remainingAddresses = document.querySelectorAll('.address-item');
            });
        });
        document.querySelectorAll('.delete-address').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn reload trang

                const addressId = this.getAttribute('data-id'); // Lấy ID của địa chỉ
                const addressRow = document.getElementById(
                    `address-row-${addressId}`); // Tìm dòng tương ứng

                // Gửi yêu cầu xóa
                fetch(`/address/${addressId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            addressRow.remove(); // Xóa dòng khỏi giao diện
                        } else {
                            alert(data.message); // Báo lỗi
                        }
                    })
            });
        });
        // nút chọn địa
        document.querySelectorAll('.select-address').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn trình duyệt reload

                const selectedId = this.getAttribute('data-id');

                // Đặt radio tương ứng được chọn
                document.getElementById(`address-${selectedId}`).checked = true;

                // Đổi giao diện nếu cần (ví dụ: highlight địa chỉ được chọn)
                document.querySelectorAll('.form-item').forEach(function(item) {
                    item.classList.remove('selected'); // Xóa trạng thái selected
                });
                this.closest('.form-item').classList.add('selected'); // Đánh dấu địa chỉ được chọn
            });
        });

        // phương thức thanh toán
        document.querySelectorAll('input[name="payment_id"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                const paymentButtonCOD = document.querySelector('#payment-button');
                const paymentButtonMoMo = document.querySelector('#momoPayment');
                const vnPayment = document.querySelector('#VNPayment');
                if (this.value == 1) { // Hiển thị COD
                    paymentButtonCOD.style.display = 'block';
                    paymentButtonMoMo.style.display = 'none';
                    vnPayment.style.display = 'none';
                } else if (this.value == 2) { // Hiển thị MoMo
                    paymentButtonCOD.style.display = 'none';
                    paymentButtonMoMo.style.display = 'block';
                    vnPayment.style.display = 'none';
                } else if (this.value == 3) { // Hiển thị VNPAY
                    paymentButtonMoMo.style.display = 'none';
                    paymentButtonCOD.style.display = 'none';
                    vnPayment.style.display = 'block';
                }
            });
        });
        // Khởi tạo giá gốc ban đầu bên ngoài hàm để dùng lại
    </script>

@endsection

@push('scriptStore')
@endpush
