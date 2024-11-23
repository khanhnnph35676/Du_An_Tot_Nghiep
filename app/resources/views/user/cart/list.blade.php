@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Giỏ hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Giỏ hàng</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->

    @if (session('success'))
        <div class="success">
            <div class="alert alert-primary alert-dismissible alert-alt solid fade show">
                @if (session('success'))
                    <strong>{{ session('success') }}</strong>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // print_r($cart);
                            // print_r(Auth::user()->rule_id );
                            $price = 0;
                        @endphp
                        @if (Auth::user())
                            @foreach ($products as $product)
                                @foreach ($cart as $item)
                                    @if ($product->id == $item['product_id'] && $product->type === '1' && Auth::id() == $item['user_id'])
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center">
                                                    <img src=" {{ asset($product->image) }}"
                                                        class="img-fluid me-5 rounded-circle"
                                                        style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                    {{ $product->name }}
                                                </div>
                                            </th>
                                            <td>
                                                @php
                                                    $price += $product->price;
                                                @endphp
                                                <p class="mb-0 mt-4">{{ number_format($product->price) . ' VNĐ' }}</p>
                                            </td>
                                            <td>
                                                <div class="input-group quantity mt-4" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-center border-0"
                                                        value="{{ $item['qty'] }}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('removeItemCartDetail', $item['product_id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-md rounded-circle bg-light border mt-4">
                                                        <i class="fa fa-times text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($productVariants as $productVariant)
                                        @if (
                                            $product->id == $item['product_id'] &&
                                                $item['product_variant_id'] == $productVariant->id &&
                                                Auth::id() == $item['user_id']
                                        )
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src=" {{ asset($productVariant->image) }}"
                                                            class="img-fluid me-5 rounded-circle"
                                                            style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                        {{ $product->name . ' - ' . $productVariant->sku }}
                                                    </div>
                                                </th>
                                                <td>
                                                    @php
                                                        $price += $productVariant->price;
                                                    @endphp
                                                    <p class="mb-0 mt-4">
                                                        {{ number_format($productVariant->price) . ' VNĐ' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center border-0"
                                                            value="{{ $item['qty'] }}">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('removeItemCart', $item['product_variant_id']) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-md rounded-circle bg-light border mt-4">
                                                            <i class="fa fa-times text-danger"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @else
                            @foreach ($products as $product)
                                @foreach ($cart as $item)
                                    @if ($product->id == $item['product_id'] && $product->type === '1' && Auth::id() != $item['user_id'])
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center">
                                                    <img src=" {{ asset($product->image) }}"
                                                        class="img-fluid me-5 rounded-circle"
                                                        style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                    {{ $product->name }}
                                                </div>
                                            </th>
                                            <td>
                                                @php
                                                    $price += $product->price;
                                                @endphp
                                                <p class="mb-0 mt-4">{{ number_format($product->price) . ' VNĐ' }}</p>
                                            </td>
                                            <td>
                                                <div class="input-group quantity mt-4" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-center border-0"
                                                        value="{{ $item['qty'] }}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('removeItemCartDetail', $item['product_id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-md rounded-circle bg-light border mt-4">
                                                        <i class="fa fa-times text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($productVariants as $productVariant)
                                        @if (
                                            $product->id == $item['product_id'] &&
                                                $item['product_variant_id'] == $productVariant->id &&
                                                $item['user_id'] == null)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src=" {{ asset($productVariant->image) }}"
                                                            class="img-fluid me-5 rounded-circle"
                                                            style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                        {{ $product->name . ' - ' . $productVariant->sku }}
                                                    </div>
                                                </th>
                                                <td>
                                                    @php
                                                        $price += $productVariant->price;
                                                    @endphp
                                                    <p class="mb-0 mt-4">
                                                        {{ number_format($productVariant->price) . ' VNĐ' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center border-0"
                                                            value="{{ $item['qty'] }}">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-md rounded-circle bg-light border mt-4">
                                                        <i class="fa fa-times text-danger"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Mã giảm giá">
                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Áp dụng</button>
            </div>
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0"> @php echo number_format($price).' VNĐ';  @endphp</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Shipping</h5>
                                <div class="">
                                    <p class="mb-0">Flat rate: 15,000 VNĐ</p>
                                </div>
                            </div>
                            <p class="mb-0 text-end">Shipping to Ha Noi.</p>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4">@php echo number_format($price + 15000).' VNĐ';  @endphp</p>
                        </div>
                        @php
                            $hasEmptyUserId = false;
                        @endphp
                        @if (Auth::user())
                            @foreach ($cart as $item)
                                @if ($item['user_id'] == Auth::user()->id)
                                    @php
                                        $hasEmptyUserId = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        @if (Auth::check())
                            @if (Auth::user()->id && $hasEmptyUserId = false)
                                <a href=""
                                    class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                    Proceed Checkout
                                </a>
                            @elseif(Auth::user()->id && $hasEmptyUserId = true)
                                <a href="{{route('storeCheckout')}}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                    Proceed Checkout
                                </a>
                            @else
                                <a href="{{ route('user.login') }}"
                                    class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                    Proceed Checkout
                                </a>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <!-- Sản phẩm nổi bật -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach ($bestProducts as $product)
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="{{ asset($product->image) }}" style="height: 270px; object-fit: cover;"
                                class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                            style="top: 10px; right: 10px;">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </div>
                        <div class="p-4 pb-0 rounded-bottom">
                            <h4>{{ $product->name }}</h4>
                            <p>{{ Str::limit($product->description, 50) }}</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold">{{ number_format($product->price) }} vnđ</p>
                                <a href=""
                                    class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@push('scriptStore')
@endpush
