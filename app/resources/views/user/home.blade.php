@extends('user.layout.default')
@push('styleStore')
    <style>
        .variant {
            height: auto;
            display: flex;
            align-items: center;
            margin: 10px 0px 10px 0px;
        }
    </style>
@endpush
@section('content')
    <!-- Hero Start -->
    <div class="container-fluid py-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Snack chất lượng</h4>
                    <h1 class="mb-5 display-3 text-primary">Snack sạch, vị ngon tự nhiên</h1>
                    {{-- <div class="position-relative mx-auto">
                        <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded" type="number"
                            placeholder="Tìm kiếm">
                        <button type="submit"
                            class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded text-white h-100"
                            style="top: 0; right: 25%;">Gửi ngay</button>
                    </div> --}}
                </div>
                <div class="col-md-12 col-lg-5">
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
{{-- 
<div class="container-fluid banner bg-secondary my-5">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="py-4">
                    <h2 class="display-6 text-white">Đồ ăn vặt độc đáo </h2>
                    <h3 class="display-6 text-dark mb-4">mới lạ trong từng món</h3>
                    <p class="mb-4 text-dark">Khám phá thế giới đồ ăn vặt phong phú và độc đáo tại cửa hàng của chúng
                        tôi.
                        Từ bánh tráng cuốn, trái cây sấy giòn rụm, đến kẹo ngọt nhập khẩu – tất cả đều mang đến hương vị
                        khó quên!</p>
                    <a href="#" class="banner-btn btn border-2 border-white rounded text-dark py-3 px-5">MUA</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/9fd15a185094509.655dc7178246f.jpg"
                        style="width: 300px; height: 300px; object-fit: cover;" class="img-fluid w-100 rounded"
                        alt="">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute"
                        style="width: 140px; height: 140px; top: 0; left: 0;">
                        <h1 style="font-size: 100px;">1</h1>
                        <div class="d-flex flex-column">
                            <span class="h2 mb-0">50$</span>
                            <span class="h4 text-muted mb-0">kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <!-- Featurs Section Start -->
    <div class="container-fluid featurs">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Miễn phí ship</h5>
                            <p class="mb-0">Đặt hàng trên 100.000 Vnđ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Thanh toán bảo mật</h5>
                            <p class="mb-0">Thanh toán bảo mật 100%</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Trả hàng</h5>
                            <p class="mb-0">Trả lại tiền trong vòng 7 ngày</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Hỗ trợ 24/7</h5>
                            <p class="mb-0">Hỗ trợ mọi lúc nhanh chóng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->

    <!-- List Product-->
    <div class="container-fluid fruite">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Sản phẩm chúng tôi</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li>
                                <a href="{{ route('storeListProduct') }}" style="background: rgba(203, 203, 203, 0.305);"
                                    class="d-flex p-3 m-2 py-2 text-dark rounded active fw-bold">
                                    Tất cả sản phẩm
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4 d-flex">
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <form action="{{ route('addToCart') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_qty" value="{{$product->qty}}">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <a href="{{ route('product.detail', $product->id) }}">
                                                            <img src="{{ asset($product->image) }}"
                                                                style="width: 50px; height: 250px; object-fit: cover;"
                                                                class="img-fluid w-100 rounded-top"
                                                                alt="{{ $product->name }}">
                                                        </a>
                                                    </div>
                                                    @if ($discount != [])
                                                        @php
                                                            // print_r($discount);
                                                            $countDiscount = 0;
                                                        @endphp
                                                        @foreach ($discount as $key => $item)
                                                            @if ($item->product_id == $product->id &&
                                                                    $discount[$key]->priority <= $discount[$key++]->priority &&
                                                                    $item->discounts->start_date < $item->discounts->end_date &&
                                                                    $item->discounts->qty > 0)
                                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                                    style="top: 5px; left: 5px;">
                                                                    Giảm {{ number_format($item->discounts->discount) }}%
                                                                </div>
                                                                @php
                                                                    $countDiscount += $item->discounts->discount;
                                                                @endphp
                                                                <input hidden type="text" name="discount"
                                                                    value="{{ $countDiscount }}">
                                                                <input hidden type="text" name="discount_id"
                                                                    value="{{ $item->discount_id }}">
                                                            @break;
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                    <input hidden name="qty" value="1">
                                                    <p class="text-start text-dark fs-6 fw-bold">{{Str::words(strip_tags($product->name), 6, '...') }}</p>
                                                    <div class="variant d-flex flex-wrap">
                                                        @php
                                                            $hasVariants = false;
                                                        @endphp

                                                        @foreach ($product_variants as $product_variant)
                                                            @if ($product_variant->product_id == $product->id)
                                                                @php
                                                                    $hasVariants = true;
                                                                @endphp
                                                                    <button type="button"class="btn border border-secondary rounded px-2 me-2  mt-2 text-primary"
                                                                    onclick="showOptionValue('{{ $product->id }}', '{{ $product_variant->id }}', '{{ $product_variant->stock }}')">
                                                                        <span>{{ $product_variant->options->option_value }}</span>
                                                                    </button>
                                                                    <span class="text-danger"> {{$product_variant->stock <= 0 ? 'Hết hàng' :''}} </span>
                                                            @endif
                                                        @endforeach
                                                        <input type="hidden" id="optionValueInput{{ $product->id }}"
                                                            name="product_variant_id" value="">
                                                    </div>
                                                    <div class="d-flex">
                                                        @if ($countDiscount == 0)
                                                            <p class="text-dark fs-5 fw-bold mb-0">
                                                                {{ number_format($product->price) }}
                                                                Vnđ
                                                            </p>
                                                        @else
                                                            <p class="text-dark fs-5 fw-bold mb-0">
                                                                {{ number_format($product->price - $product->price * ($countDiscount / 100)) }}
                                                                Vnđ
                                                            </p>
                                                            <del class="fs-6 ms-2"> {{ number_format($product->price) }}Vnđ</del>
                                                        @endif
                                                    </div>
                                                    <br>
                                                    <input type="text" id="stockInput{{ $product->id }}" name="stock" value="0" hidden>

                                                    <div class="d-flex">
                                                        <button onclick="validateSelection('{{ $product->id }}')"
                                                            class="btn border border-secondary rounded px-3 text-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $product->id }}"
                                                            @if ($hasVariants) disabled @endif
                                                            id="addToCartButton{{ $product->id }}">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                            Thêm vào giỏ
                                                        </button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Thêm các tab khác nếu cần -->
        </div>
    </div>
</div>
</div>
<!-- Fruits Shop End-->
<!-- Featurs Start -->
{{-- <div class="container-fluid service">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <a href="#">
                    <div class="service-item bg-secondary rounded border border-secondary">
                        <img src="img/featur-1.jpg" class="img-fluid rounded-top w-100" alt="">
                        <div class="px-4 rounded-bottom">
                            <div class="service-content bg-primary text-center p-4 rounded">
                                <h5 class="text-white">Khô gà</h5>
                                <h4 class="mb-0">Giảm 20%</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="#">
                    <div class="service-item bg-dark rounded border border-dark">
                        <img src="img/featur-2.jpg" class="img-fluid rounded-top w-100" alt="">
                        <div class="px-4 rounded-bottom">
                            <div class="service-content bg-light text-center p-4 rounded">
                                <h5 class="text-primary">Khô bò</h5>
                                <h4 class="mb-0">Miễn phí ship</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="#">
                    <div class="service-item bg-primary rounded border border-primary">
                        <img src="img/featur-3.jpg" class="img-fluid rounded-top w-100" alt="">
                        <div class="px-4 rounded-bottom">
                            <div class="service-content bg-secondary text-center p-4 rounded">
                                <h5 class="text-white">Bánh tráng</h5>
                                <h4 class="mb-0">Giảm 30.000 Vnđ</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> --}}
<!-- Featurs End -->


<!-- Vesitable Shop Start-->
{{-- <div class="container-fluid vesitable">
    <div class="container py-3">
        <h2 class="mb-3">Danh mục sản phẩm</h2>
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-3 mb-2">
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                style="width: 50px; height: 250px; object-fit: cover;"
                                class="img-fluid w-100 rounded-top" alt="{{ $category->name }}">
                        </div>
                        <div class="p-4 rounded-bottom">
                            <h4>{{ $category->name }}</h4>
                            <p>{{ $category->description }}</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <a href="#" class="btn border border-secondary rounded px-3 text-primary">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div> --}}
<!-- Vesitable Shop End -->


<!-- Banner Section Start-->

<!-- Banner Section End -->


<!-- list product Start -->
{{-- <div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-4">Sản phẩm bán chạy nhất</h1>
            <p>Khám phá các món ăn vặt được yêu thích nhất tại cửa hàng chúng tôi,
                được chọn lọc kỹ càng để mang đến hương vị tuyệt vời và chất lượng tốt nhất!</p>
        </div>
        <div class="row g-4">
            @foreach ($bestViewedProducts as $product)
                <div class="col-lg-6 col-xl-4">
                    <div class="p-4 rounded bg-light">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <!-- Hiển thị ảnh sản phẩm -->
                                <a href="{{ route('product.detail', $product->id) }}">
                                    <img src="{{ asset($product->image) }}" style="height: 170px; object-fit: cover;"
                                        class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="col-6">
                                <!-- Hiển thị tên và giá sản phẩm -->
                                <form action="{{ route('addToCart') }}" method="POST"
                                    id="addToCartForm{{ $product->id }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input hidden name="qty" value="1">
                                    <input type="hidden" id="optionValueInput{{ $product->id }}"
                                        name="product_variant_id" value="">

                                    <a href="{{ route('product.detail', $product->id) }}"
                                        class="h5">{{ $product->name }}</a>
                                    <p class="mb-3 fs-6 text-secondary fw-bold" id="product-price">{{ number_format($product->price, 2) }} Vnđ</p>

                                    <div class="variant">
                                        @php
                                            $hasVariants = false;
                                        @endphp

                                        @foreach ($product_variants as $product_variant)
                                            @if ($product_variant->product_id == $product->id)
                                                @php
                                                    $hasVariants = true;
                                                @endphp
                                                <button type="button"
                                                    class="btn border border-secondary rounded px-3 text-primary"
                                                    onclick="selectVariant('{{ $product_variant->id }}', '{{ $product->id }}')">
                                                    <span>{{ $product_variant->options->option_value }}</span>
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>

                                    <button type="button" id="addToCartButton{{ $product->id }}"
                                        class="btn border border-secondary rounded px-3 text-primary"
                                        onclick="openModalIfValid('{{ $product->id }}', {{ $hasVariants ? 'true' : 'false' }})">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                        Thêm vào giỏ
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> --}}
<!-- Bestsaler Product End -->


<!-- Fact Start -->
{{-- <div class="container-fluid py-5">
    <div class="container">
        <div class="bg-light p-5 rounded">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>Khách hàng hài lòng</h4>
                        <h1>1963</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>Chất lượng dịch vụ</h4>
                        <h1>99%</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>Đánh giá khách hàng</h4>
                        <h1>33</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>Sản phẩm có sẵn</h4>
                        <h1>789</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Fact Start -->


<!-- Tastimonial Start -->
{{-- <div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="testimonial-header text-center">
            <h4 class="text-primary">Our Testimonial</h4>
            <h1 class="display-5 mb-5 text-dark">Our Client Saying!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item img-border-radius bg-light rounded p-4">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                        style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                            industry's standard dummy text ever since the 1500s,
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/testimonial-1.jpg" class="img-fluid rounded"
                                style="width: 100px; height: 100px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Client Name</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-item img-border-radius bg-light rounded p-4">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                        style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                            industry's standard dummy text ever since the 1500s,
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/testimonial-1.jpg" class="img-fluid rounded"
                                style="width: 100px; height: 100px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Client Name</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-item img-border-radius bg-light rounded p-4">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                        style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                            industry's standard dummy text ever since the 1500s,
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/testimonial-1.jpg" class="img-fluid rounded"
                                style="width: 100px; height: 100px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Client Name</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Tastimonial End -->
<script>
    function selectVariant(variantId, productId) {
        // Lấy giá từ biến thể tương ứng
        const variant = @json($product_variants).find(v => v.id == variantId);
        if (variant) {
            // Cập nhật giá
            document.getElementById('product-price').innerText = parseFloat(variant.price).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        }
    }

    function showOptionValue(productId, variantId,stock) {
        const input = document.getElementById(`optionValueInput${productId}`);
        const addToCartButton = document.getElementById(`addToCartButton${productId}`);
        const stockInput = document.getElementById(`stockInput${productId}`);
        if (input && addToCartButton) {
            input.value = variantId; // Gán giá trị của biến thể
            addToCartButton.disabled = false; // Bật nút thêm vào giỏ
            stockInput.value = stock;
        }
    }

    function validateSelection(productId) {
        const input = document.getElementById('optionValueInput' + productId);
        const addToCartButton = document.getElementById('addToCartButton' + productId);

        if (input && addToCartButton && !input.value) {
            return false;
        }
        return true;
    }

    // Hàm để chọn biến thể
    function selectVariant(variantId, productId) {
        // Lưu giá trị ID biến thể vào input hidden
        document.getElementById(`optionValueInput${productId}`).value = variantId;
    }

    // Kiểm tra trước khi hiển thị modal
    function openModalIfValid(productId, hasVariants) {
        const selectedVariant = document.getElementById(`optionValueInput${productId}`).value;

        if (hasVariants && !selectedVariant) {
            return false;
        }

        // Mở modal nếu là sản phẩm đơn thể hoặc đã chọn biến thể
        const modal = new bootstrap.Modal(document.getElementById(`exampleModal${productId}`));
        modal.show();
    }
</script>
@endsection

@push('scriptStore')
@endpush
