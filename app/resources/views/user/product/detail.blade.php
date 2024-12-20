@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
    <style>

    </style>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi tiết sản phẩm</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Chi tiết sản phẩm</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-3">
        <div class="container">
            @if (session('message'))
                <div class="message">
                    <div class="alert alert-primary alert-dismissible alert-alt solid fade show mb-5">
                        @if (session('message'))
                            <strong>{{ session('message') }}</strong>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="row g-4 mb-2 border">
                <div class="col-lg-12 col-xl-12">
                    <div class="row g-4">
                        {{-- form thêm vào giỏ hàng --}}
                        <div class="col-lg-5">
                            <div>
                                <img src=" {{ asset($product->image) }} " style="width:100%; max-height:100%;"
                                    alt="Image">
                            </div>
                            @if ($product->type == 2)
                                @foreach ($productVariant as $item)
                                    <img src="{{ asset($item->image) }}" class="me-2 mt-3" class="images_pro"
                                        style="width: 40px; height: 40px; object-fit: cover;cursor: pointer">
                                @endforeach
                            @endif
                            @if ($galleries != [])
                                @foreach ($galleries as $item)
                                    <img src="{{ asset($item->image) }}" class="me-2 mt-3" class="images_pro"
                                        style="width: 40px; height: 40px; object-fit: cover;cursor: pointer">
                                @endforeach
                            @endif
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-6">
                            @php
                                $checkAdd = 1;
                            @endphp
                            <form id="product-form" action="{{ route('addToCartDetai', ['checkAdd' => $checkAdd]) }}"
                                method="POST">
                                @csrf
                                <input type="text" name='product_id' value="{{ $product->id }}" hidden>
                                <input type="text" name="discount_id"
                                    value="{{ $discount->discounts->id ?? '0' }}"hidden>
                                <input type="text" name="discount"value="{{ $discount->discounts->discount ?? '0' }}"
                                    hidden>
                                <input type="text" name="product_qty"value="{{ $product->qty }}" hidden>
                                <p class="fw-bold mb-4 fs-3">{{ $product->name }}</p>
                                <p class="fw-bold mb-4 fs-4" id="variant-price">Giá:
                                    @if ($discount != [])
                                        {{ number_format($product->price - ($product->price * $discount->discounts->discount) / 100) }}
                                        Vnđ
                                    @else
                                        {{ number_format($product->price) }} Vnđ
                                    @endif
                                </p>
                                @php
                                    $stock = 0;
                                @endphp

                                <div class="d-flex align-items-center mb-4">
                                    <span class="me-3">Số lượng: </span>
                                    <div class="input-group quantity" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                type='button'>
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="qty" value="1" min="1" max="50"
                                            class="qty form-control form-control-sm text-center border-0">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                type='button'>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('qty')
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                                <div class="div">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="me-2">Phân loại: </span>
                                        @if ($product->type == 1)
                                            Không có
                                        @else
                                            @foreach ($productVariant as $item)
                                                <button class="badge bg-white text-dark border m-1 variant-option"
                                                    type="button" data-variant-id="{{ $item->id }}"
                                                    data-variant-price="{{ $item->price }}"
                                                    data-variant-stock="{{ $item->stock }}">
                                                    <!-- Thêm thuộc tính stock -->
                                                    @php
                                                        $stock += $item->stock;
                                                    @endphp

                                                    <img src="{{ asset($item->image) }}" class="me-2"
                                                        style="width: 20px; height: 20px; object-fit: cover;">
                                                    {{ $item->options->option_value }}
                                                </button>
                                            @endforeach
                                    </div>
                                    @error('product_variant_id')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                    @if ($stock > 0)
                                        <p>Tổng số lượng: {{ $stock }}</p>
                                    @else
                                        <p class="text-danger">{{ $stock == 0 ? 'Hết hàng' : '' }}</p>
                                    @endif
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">Số lượng sản phẩm của biến thể :</span>
                                        <input id="stock" type="text" class="form-control" style="width:60px;"
                                            name="stock" value="0">
                                    </div>
                                    @endif
                                </div>
                                {{-- <input type="text" name="product_id" value="{{$product_id}}">
                                <input type="text" name="product_variant_id" value="{{$product_id}}"> --}}
                                <input id="product_variant_id" type="text" name="product_variant_id" hidden>
                                <div class="mt-3">
                                    <button class="btn border border-secondary rounded px-4 py-2 mb-4 me-2 text-primary"
                                        type="button" onclick="setCheckAdd(1)">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào giỏ
                                    </button>
                                    <button class="btn border border-secondary rounded px-4 py-2 mb-4 text-primary"
                                        type="button" onclick="setCheckAdd(2)">
                                        Mua ngay
                                    </button>
                                </div>
                                @if (session('error'))
                                    <div class="error">
                                        <div class="alert alert-danger alert-dismissible alert-alt solid fade show">
                                            <button type="button" class="close h-100" data-dismiss="alert"
                                                aria-label="Close">
                                            </button>
                                            @if (session('error'))
                                                <strong>{{ session('error') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </form>
                            {{-- yeu thich
                            <input type="text" name='product_id' value="{{ $product->id }}" > --}}
                        </div>
                    </div>
                    <div class="col-lg-12 m-4">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0" type="button"
                                    role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                    aria-controls="nav-about" aria-selected="true">Mô
                                    tả</button>
                                <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                    id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                    aria-controls="nav-mission" aria-selected="false">Đánh giá</button>
                            </div>
                        </nav>
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p class="mb-4">{!! $product->description !!}</p>
                            </div>
                            <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                <div class="d-flex">
                                    <div id="testimonial-list">
                                        @if (!empty($product->testimonials) && count($product->testimonials) > 0)
                                            @foreach ($product->testimonials as $testimonial)
                                                <div class="d-flex mb-4">
                                                    <img src="{{ asset($testimonial->user->avatar ?? 'default-avatar.png') }}"
                                                        class="img-fluid rounded-circle p-3"
                                                        style="width: 100px; height: 100px;" alt="User Avatar">
                                                    <div>
                                                        <p class="mb-2" style="font-size: 14px;">
                                                            {{ $testimonial->created_at->format('d M, Y') }}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <h5>{{ $testimonial->user->name ?? 'Ẩn danh' }}</h5>
                                                            <div class="d-flex mb-3">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="fa {{ $i <= $testimonial->rating ? 'fa-star text-secondary' : 'fa-star text-muted' }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <p>{{ $testimonial->content }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>Chưa có đánh giá nào.</p>
                                        @endif
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Đánh giá --}}

            <div class="vesitable mt-3">
                <h2 class="fw-bold mb-3">Sản phẩm liên quan</h2>
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($relatedProducts as $related)
                        <div class="border border-primary rounded position-relative vesitable-item" style="height:450px;">
                            <div class="vesitable-img">
                                <a href="{{ route('product.detail', $related->id) }}">
                                    <img src="{{ asset($related->image) }}"
                                        style="width: 50px; height: 250px; object-fit: cover;"
                                        class="img-fluid w-100 rounded-top" alt="{{ $related->name }}">
                                </a>
                            </div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <p class="text-dark fw-bold fs-6">{{ Str::words(strip_tags($related->name), 4, '...') }}
                                </p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">{{ number_format($related->price) }} Vnđ</p>
                                </div>

                            </div>
                            <div class="variant d-flex flex-wrap ms-3">
                                @php
                                    $hasVariants = false;
                                @endphp

                                @foreach ($product_variants as $product_variant)
                                    @if ($product_variant->product_id == $product->id)
                                        @php
                                            $hasVariants = true;
                                        @endphp
                                        <button
                                            type="button"class="btn border border-secondary rounded px-2 me-2  mt-2 text-primary"
                                            onclick="showOptionValue('{{ $product->id }}', '{{ $product_variant->id }}', '{{ $product_variant->stock }}')">
                                            <span>{{ $product_variant->options->option_value }}</span>
                                        </button>
                                        <span class="text-danger">
                                            {{ $product_variant->stock <= 0 ? 'Hết hàng' : '' }}
                                        </span>
                                    @endif
                                @endforeach
                                <input type="hidden" id="optionValueInput{{ $product->id }}" name="product_variant_id"
                                    value="">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
    <script>
        function setCheckAdd(value) {
            const form = document.getElementById('product-form');
            const baseUrl = "{{ route('addToCartDetai', ['checkAdd' => ':checkAdd']) }}";
            form.action = baseUrl.replace(':checkAdd', value);
            form.submit(); // Gửi form sau khi đổi URL
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.variant-option').forEach(button => {
                button.addEventListener('click', function() {
                    // Nếu nút hiện tại đã là bg-secondary, chuyển về bg-white
                    if (this.classList.contains('bg-secondary')) {
                        this.classList.remove('bg-secondary');
                        this.classList.add('bg-white');
                        const variantId = this.getAttribute(
                            'data-variant-id'); // Lấy giá trị variant-id
                        document.getElementById('product_variant_id').value = 0;
                        document.getElementById('stock').value = 0; // Đặt lại số lượng khi hủy chọn
                    } else {
                        // Đảm bảo chỉ một nút được chọn, các nút khác chuyển về bg-white
                        document.querySelectorAll('.variant-option').forEach(b => {
                            b.classList.remove('bg-secondary');
                            b.classList.add('bg-white');
                        });
                        const variantId = this.getAttribute(
                            'data-variant-id'); // Lấy giá trị variant-id
                        document.getElementById('product_variant_id').value = variantId;

                        this.classList.remove('bg-white');
                        this.classList.add('bg-secondary');


                        const variantPrice = this.getAttribute('data-variant-price');
                        // Lấy số lượng từ data-variant-price và hiển thị vào trường nhập liệu #stock
                        // Giả sử bạn có thuộc tính stock cho biến thể
                        const variantStock = this.getAttribute(
                            'data-variant-stock');

                        document.getElementById('stock').value =
                            variantStock; // Cập nhật giá trị stock
                    }

                    // Ẩn thông báo lỗi nếu có (đảm bảo biến variantError được định nghĩa)
                    if (typeof variantError !== 'undefined') {
                        variantError.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection

@push('scriptStore')
@endpush
