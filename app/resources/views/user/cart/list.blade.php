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
    <div class="container-fluid py-5">
        <div class="container py-5">
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">
                                <input type="checkbox" id="select-all" style="transform: scale(1.2);"
                                    class="form-check-input">
                            </th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" style="width:20%;">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // print_r($cart);
                            // print_r(Auth::user()->rule_id );
                        @endphp
                        @if (Auth::user())
                            @foreach ($products as $product)
                                @foreach ($cart as $item)
                                    @if ($product->type == 1 && $product->id == $item['product_id'] &&  $item['user_id'] != 0)
                                        <tr>
                                            <td style="width:100px;" class="text-center align-middle">
                                                <input type="checkbox" class="form-check-input select-item"
                                                    name="selected_products[{{ $product->id }}]" value="1"
                                                    style="transform: scale(1.2);" onchange="updateCart2(this)"
                                                    @if ($item['selected_products'] == 1) checked @endif>
                                            </td>
                                            <th scope="row">
                                                <div class="d-flex align-items-center">
                                                    <img src=" {{ asset($product->image) }}"
                                                        class="img-fluid me-5 rounded-circle"
                                                        style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                    {{ $product->name }}
                                                </div>
                                            </th>
                                            <td>
                                                <div class="input-group quantity mt-4" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                            onclick="updateQtyNonVariant({{ $item['product_id'] }}, {{ $item['qty'] - 1 }})">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-center border-0"
                                                        id="qty-non-variant-{{ $item['product_id'] }}"
                                                        value="{{ $item['qty'] }}"
                                                        onchange="updateQtyByInput('{{ $item['product_id'] }}', '{{ $item['product_variant_id'] ?? 'null' }}', this.value)">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                            onclick="updateQtyNonVariant({{ $item['product_id'] }}, {{ $item['qty'] + 1 }})">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span id="error-message-{{ $item['product_id'] }}" class="mt-1"
                                                    style="color: red; display: none;"></span>
                                                <span
                                                    id="error-message-{{ $item['product_id'] }}-{{ $item['product_variant_id'] ?? 'null' }}"
                                                    class="mt-1 text-danger" style="display: none;"></span>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">
                                                    @if ($item['discount'] != 0)
                                                        {{ number_format($product->price - ($product->price * $item['discount']) / 100) . ' Vnđ' }}
                                                    @else
                                                        {{ number_format($product->price) . ' Vnđ' }}
                                                    @endif
                                                </p>
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
                                                <td style="width:100px;" class="text-center align-middle">
                                                    <input type="checkbox" class="form-check-input select-item"
                                                        name="selected_products[{{ $product->id }}]" value="1"
                                                        style="transform: scale(1.2);" onchange="updateCart2(this)"
                                                        @if ($item['selected_products'] == 1) checked @endif>
                                                </td>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src=" {{ asset($productVariant->image) }}"
                                                            class="img-fluid me-5 rounded-circle"
                                                            style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                        {{ $product->name . ' - ' . $productVariant->sku }}
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                                onclick="updateCart({{ $item['product_id'] }}, {{ $item['product_variant_id'] ?? 'null' }}, {{ $item['qty'] - 1 }})">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center border-0"
                                                            id="qty-{{ $item['product_id'] }}-{{ $item['product_variant_id'] ?? 'null' }}"
                                                            value="{{ $item['qty'] }}"
                                                            onchange="updateQtyByInput('{{ $item['product_id'] }}', '{{ $item['product_variant_id'] ?? 'null' }}', this.value)">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                                onclick="updateCart({{ $item['product_id'] }}, {{ $item['product_variant_id'] ?? 'null' }}, {{ $item['qty'] + 1 }})">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span id="error-message" class="mt-1"
                                                        style="color: red; display: none;"></span>
                                                    <span
                                                        id="error-message-{{ $item['product_id'] }}-{{ $item['product_variant_id'] ?? 'null' }}"
                                                        class="mt-1 text-danger" style="display: none;"></span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">
                                                        @if ($item['discount'] != 0)
                                                            {{ number_format($productVariant->price - ($productVariant->price * $item['discount']) / 100) . ' Vnđ' }}
                                                        @else
                                                            {{ number_format($productVariant->price) . ' Vnđ' }}
                                                        @endif
                                                    </p>
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
                                    @if (
                                        $product->type == 1 &&
                                            $item['product_variant_id'] == '' &&
                                            $product->id == $item['product_id'] &&
                                            $item['user_id'] == 0)
                                        <tr>
                                            <td style="width:100px;" class="text-center align-middle">
                                                <input type="checkbox" class="form-check-input select-item"
                                                    name="selected_products[{{ $product->id }}]" value="1"
                                                    style="transform: scale(1.2);" onchange="updateCart2(this)"
                                                    @if ($item['selected_products'] == 1) checked @endif>
                                            </td>
                                            <th scope="row">
                                                <div class="d-flex align-items-center">
                                                    <img src=" {{ asset($product->image) }}"
                                                        class="img-fluid me-5 rounded-circle"
                                                        style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                    {{ $product->name }}
                                                </div>
                                            </th>
                                            <td>
                                                <div class="input-group quantity mt-4" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                            onclick="updateQtyNonVariant({{ $item['product_id'] }}, {{ $item['qty'] - 1 }})">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-center border-0"
                                                        id="qty-{{ $item['product_id'] }} }}"
                                                        value="{{ $item['qty'] }}"
                                                        onchange="updateQtyByInput('{{ $item['product_id'] }}', '{{ $item['product_variant_id'] ?? 'null' }}', this.value)">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                            onclick="updateQtyNonVariant({{ $item['product_id'] }}, {{ $item['qty'] + 1 }})">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span id="error-message" class="mt-1"
                                                    style="color: red; display: none;"></span>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">
                                                    @if ($item['discount'] != 0)
                                                        {{ number_format($product->price - ($product->price * $item['discount']) / 100) . ' Vnđ' }}
                                                    @else
                                                        {{ number_format($product->price) . ' Vnđ' }}
                                                    @endif
                                                </p>
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
                                        @if ($product->id == $item['product_id'] && $item['product_variant_id'] == $productVariant->id && $item['user_id'] == 0)
                                            <tr>
                                                <td style="width:100px;" class="text-center align-middle">
                                                    <input type="checkbox" class="form-check-input select-item"
                                                        name="selected_products[{{ $product->id }}]" value="1"
                                                        style="transform: scale(1.2);" onchange="updateCart2(this)"
                                                        @if ($item['selected_products'] == 1) checked @endif>
                                                </td>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src=" {{ asset($productVariant->image) }}"
                                                            class="img-fluid me-5 rounded-circle"
                                                            style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                                        {{ $product->name . ' - ' . $productVariant->sku }}
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                                onclick="updateCart({{ $item['product_id'] }}, {{ $item['product_variant_id'] ?? 'null' }}, {{ $item['qty'] - 1 }})">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center border-0"
                                                            id="qty-{{ $item['product_id'] }}-{{ $item['product_variant_id'] ?? 'null' }}"
                                                            value="{{ $item['qty'] }}"
                                                            onchange="updateQtyByInput('{{ $item['product_id'] }}', '{{ $item['product_variant_id'] ?? 'null' }}', this.value)">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                                onclick="updateCart({{ $item['product_id'] }}, {{ $item['product_variant_id'] ?? 'null' }}, {{ $item['qty'] + 1 }})">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span id="error-message" class="mt-1"
                                                        style="color: red; display: none;"></span>
                                                    <span
                                                        id="error-message-{{ $item['product_id'] }}-{{ $item['product_variant_id'] ?? 'null' }}"
                                                        class="mt-1 text-danger" style="display: none;"></span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">
                                                        @if ($item['discount'] != 0)
                                                            {{ number_format($productVariant->price - ($productVariant->price * $item['discount']) / 100) . ' Vnđ' }}
                                                        @else
                                                            {{ number_format($productVariant->price) . ' Vnđ' }}
                                                        @endif
                                                    </p>
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
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Mã giảm giá">
                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Áp
                    dụng</button>
            </div>
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h2 class="display-6 mb-4">Tổng <span class="fw-normal">Giỏ hàng</span></h2>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Tổng giá sản phẩm</h5>
                                @php
                                    $checkPrice = false;
                                @endphp
                                @php
                                    $price = 0; // Khởi tạo biến tổng giá
                                @endphp
                                @if (Auth::check())
                                    @foreach ($cart as $item)
                                        @foreach ($products as $product)
                                            @if (
                                                $product->type == 1 &&
                                                    $item['product_variant_id'] == '' &&
                                                    $product->id == $item['product_id'] &&
                                                    Auth::id() == $item['user_id'] &&
                                                    $item['selected_products'] == 1)
                                                @php
                                                    $price += $product->price * $item['qty'];
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($productVariants as $productVariant)
                                            @if (
                                                $productVariant->product_id == $item['product_id'] &&
                                                    $item['product_variant_id'] == $productVariant->id &&
                                                    Auth::id() == $item['user_id'] &&
                                                    $item['selected_products'] == 1)
                                                @php
                                                    $price += $productVariant->price * $item['qty'];
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                @else
                                    @foreach ($cart as $item)
                                        @foreach ($products as $product)
                                            @if (
                                                $product->type == 1 &&
                                                    $item['product_variant_id'] == '' &&
                                                    $product->id == $item['product_id'] &&
                                                    $item['user_id'] == 0 &&
                                                    $item['selected_products'] == 1)
                                                @php
                                                    $price += $product->price * $item['qty'];
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($productVariants as $productVariant)
                                            @if (
                                                $productVariant->product_id == $item['product_id'] &&
                                                    $item['product_variant_id'] == $productVariant->id &&
                                                    $item['user_id'] == 0 &&
                                                    $item['selected_products'] == 1)
                                                @php
                                                    $price += $productVariant->price * $item['qty'];
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @foreach ($cart as $item)
                                    @if ($item['discount'] != 0)
                                        @php
                                            $price = $price - ($price * $item['discount']) / 100;
                                        @endphp
                                    @endif
                                @endforeach


                                @if ($price > 0)
                                    <p class="mb-0"> <strong>{{ number_format($price) }} Vnđ</strong> </p>
                                @else
                                    <p class='mb-0'> <strong>0 Vnđ </strong> </p>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Phí vận chuyển</h5>
                                <div class="">
                                    <p class="mb-0"><strong> 15,000 Vnđ</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Tổng giá</h5>
                            <p class="mb-0 pe-4"><strong>@php echo number_format($price + 15000).' Vnđ';  @endphp</strong> </p>
                        </div>
                        @if (Auth::check())
                            @php
                                $hasSelectedProduct = false;
                            @endphp
                            @foreach ($cart as $item)
                                @if ($item['user_id'] == Auth::user()->id && isset($item['selected_products']) && $item['selected_products'] == 1)
                                    @php
                                        $hasSelectedProduct = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($hasSelectedProduct)
                                <a href="{{ route('storeCheckout') }}"
                                    class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                    Thanh toán
                                </a>
                            @else
                                <p class="text-danger text-center">
                                    Bạn không có sản phẩm để thanh toán. Hãy chọn ít nhất một sản phẩm.
                                </p>
                            @endif
                        @else
                            @php
                                $hasSelectedProduct = false;
                            @endphp
                            @foreach ($cart as $item)
                                @if ($item['user_id'] == 0 && $item['selected_products'] == 1)
                                    @php
                                        $hasSelectedProduct = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($hasSelectedProduct)
                                <a href="{{ route('storeCheckout') }}"
                                    class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                    Thanh toán
                                </a>
                            @else
                                <p class="text-danger text-center">
                                    Bạn không có sản phẩm để thanh toán. Hãy chọn ít nhất một sản phẩm.
                                </p>
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
    <script>
        // nhập số nó cũng tự update
        function updateQtyByInput(productId, variantId, newQty) {
            const parsedQty = parseInt(newQty, 10);
            if (isNaN(parsedQty) || parsedQty <= 0) {
                const errorMessage = document.getElementById(`error-message`);
                errorMessage.textContent = "Số lượng phải là số nguyên lớn hơn 0.";
                errorMessage.style.display = 'block';
                setTimeout(() => {
                    location.reload(); // Reload trang sau 1 giây
                }, 300);
                return;
            }

            fetch('{{ route('updateQtyCartVariant') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        product_variant_id: variantId !== '0' ? variantId : null,
                        qty: parsedQty,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    const errorMessageElement = document.getElementById(`error-message-${productId}-${variantId}`);
                    if (data.success) {
                        location.reload();
                    } else {
                        // Hiển thị lỗi nếu không cập nhật thành công
                        errorMessageElement.textContent = data.message;
                        errorMessageElement.style.display = 'block';
                        // setTimeout(() => {
                        //     location.reload(); // Reload trang sau 1 giây
                        // }, 300);
                    }
                })
                .catch(error => {
                    errorMessageElement.textContent = data.message;
                    errorMessageElement.style.display = 'block';
                });
        }




        function updateQtyNonVariant(productId, newQty) {
            fetch('{{ route('updateCartNonVariant') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        qty: newQty,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        const errorMessageElement = document.getElementById(`error-message-${productId}`);
                        errorMessageElement.textContent = data.message;
                        errorMessageElement.style.display = 'block';
                        // setTimeout(() => {
                        //     location.reload(); // Reload trang sau 1 giây
                        // }, 300);
                    }
                });
        }

        function updateCart(productId, variantId, newQty) {
            fetch('{{ route('updateCart') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        product_variant_id: variantId === 'null' ? null : variantId,
                        qty: newQty,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    const errorMessageElement = document.getElementById('error-message');
                    if (data.success) {
                        location.reload();
                    } else {
                        errorMessageElement.textContent = data.message;
                        errorMessageElement.style.display = 'block';
                        setTimeout(() => {
                            location.reload(); // Reload trang sau 1 giây
                        }, 300);
                    }
                });
        }
        // NÚT CHỌN NHIỀU SẢN PHẨM
        document.getElementById('select-all').addEventListener('change', function() {
            // Lấy tất cả checkbox có class 'select-item'
            var checkboxes = document.querySelectorAll('.select-item');

            // Duyệt qua các checkbox và thay đổi trạng thái của chúng
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = document.getElementById('select-all').checked;
                updateCart2(checkbox); // Cập nhật trạng thái của từng checkbox vào session
            });
        });
        // Kiểm tra checkbox và bật/tắt nút thanh toán
        document.querySelectorAll('.select-item').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var isAnyChecked = document.querySelectorAll('.select-item:checked').length > 0;
                document.getElementById('checkout-btn').disabled = !isAnyChecked;
            });
        });

        // Khởi tạo trạng thái nút thanh toán khi tải trang
        window.onload = function() {
            var isAnyChecked = document.querySelectorAll('.select-item:checked').length > 0;
            document.getElementById('checkout-btn').disabled = !isAnyChecked;
        }

        function updateCart2(checkbox) {
            const productId = checkbox.name.split('[')[1].split(']')[0]; // Lấy product_id từ name attribute
            const isSelected = checkbox.checked ? 1 : 0; // Nếu checkbox được chọn, selected = 1, nếu không là 0

            // Gửi AJAX request để cập nhật session giỏ hàng với selected_products
            fetch('/update-selected-product', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        selected: isSelected
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Kiểm tra dữ liệu trả về
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <!-- Cart Page End -->
@endsection

@push('scriptStore')
@endpush
