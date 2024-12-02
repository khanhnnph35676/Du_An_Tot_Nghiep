@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
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
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        {{-- form thêm vào giỏ hàng --}}
                        <div class="col-lg-6">
                            <div>
                                <img src=" {{ asset($product->image) }} " style="width:100%;" class="img-fluid rounded"
                                    alt="Image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-4">{{ $product->name }}</h4>
                            <h3 class="fw-bold mb-4">{{ number_format($product->price) }} Vnđ</h3>
                            <div class="d-flex align-items-center mb-4">
                                <span class="me-3">Số lượng: </span>
                                <div class="input-group quantity" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" type='button'>
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="qty form-control form-control-sm text-center border-0"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border" type='button'>
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2">Loại: </span>
                                @if ($product->type == 1)
                                    Không có
                                @else
                                    @foreach ($productVariant as $item)
                                        <button class="badge bg-white text-dark border m-1 variant-option" type="button"
                                            data-variant-id="{{ $item->id }}">
                                            {{ $item->options->option_value }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                            <p id="variantError" class="text-danger" style="display: none;"></p>
                            <br>
                            <form action="" method="POST">
                                @csrf
                                {{-- <input type="text" name="product_id" value="{{$product_id}}">
                                <input type="text" name="product_variant_id" value="{{$product_id}}"> --}}
                                <button class="btn border border-secondary rounded-pill mt-2 px-4 py-2 mb-4 text-primary"
                                    id="addToCart" data-product-id="{{ $product->id }}"
                                    data-has-variants="{{ $product->type != 1 ? 'true' : 'false' }}">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào giỏ
                                </button>
                            </form>
                        </div>

                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Mô tả</button>
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
                                        <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Jason Smith</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p>The generated Lorem Ipsum is therefore always free from repetition injected
                                                humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Sam Peters</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark">The generated Lorem Ipsum is therefore always free from
                                                repetition injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor
                                        sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                        {{-- Leave a Reply --}}
                        <form action="#">
                            <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="border-bottom rounded">
                                        <input type="text" class="form-control border-0 me-4"
                                            placeholder="Yur Name *">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border-bottom rounded">
                                        <input type="email" class="form-control border-0" placeholder="Your Email *">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="border-bottom rounded my-4">
                                        <textarea name="" id="" class="form-control border-0" cols="30" rows="8"
                                            placeholder="Your Review *" spellcheck="false"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between py-3 mb-5">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 me-3">Please rate:</p>
                                            <div class="d-flex align-items-center" style="font-size: 12px;">
                                                <i class="fa fa-star text-muted"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <a href="#"
                                            class="btn border border-secondary text-primary rounded-pill px-4 py-3"> Post
                                            Comment</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <h4 class="mb-4">Featured products</h4>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded" style="width: 100px; height: 100px;">
                                    <img src="img/featur-1.jpg" class="img-fluid rounded" alt="Image">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="d-flex mb-2">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center my-4">
                                <a href="#"
                                    class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew
                                    More</a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="position-relative">
                                <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                <div class="position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Sản phẩm liên quan</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($relatedProducts as $related)
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="{{ asset($related->image) }}" class="img-fluid w-100 rounded-top"
                                    alt="{{ $related->name }}">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                style="top: 10px; right: 10px;">
                                {{ $related->category->name ?? 'Uncategorized' }}
                            </div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>{{ $related->name }}</h4>
                                <p>{!! $related->description !!}</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">{{ number_format($related->price) }} vnđ</p>
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
    </div>
    <!-- Single Product End -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButton = document.getElementById('addToCart');
            const variantError = document.getElementById('variantError');

            addToCartButton.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn form gửi đi mặc định

                const hasVariants = this.getAttribute('data-has-variants') ===
                    'true'; // Kiểm tra nếu có biến thể
                let selectedVariant = null;

                // Kiểm tra biến thể
                if (hasVariants) {
                    selectedVariant = document.querySelector('.variant-option.bg-secondary');
                    if (!selectedVariant) {
                        variantError.style.display = 'inline'; // Hiển thị lỗi
                        variantError.textContent = 'Vui lòng chọn phân loại';
                        return;
                    }
                    variantError.style.display = 'none'; // Ẩn lỗi nếu chọn đúng
                }

                // Lấy số lượng
                const quantityInput = document.querySelector('input.qty');
                const quantity = parseInt(quantityInput.value);

                // Kiểm tra số lượng hợp lệ
                if (!quantity || quantity <= 0) {
                    variantError.style.display = 'inline';
                    variantError.textContent = 'Vui lòng nhập số lượng hợp lệ';
                    return;
                }

                variantError.style.display = 'none';

                // Lấy thông tin sản phẩm
                const productId = this.getAttribute('data-product-id');
                const variantId = selectedVariant ? selectedVariant.getAttribute('data-variant-id') : null;

                // Gửi yêu cầu tới server
                fetch('add-to-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            product_variant_id: variantId,
                            qty: quantity,
                        }),
                    })
                    .then((response) => {
                        if (!response.ok) {
                            return response.json().then((data) => {
                                throw new Error(data.error || 'Có lỗi xảy ra!');
                            });
                        }
                        return response.json();
                    })
                    .then((data) => {
                        // Hiển thị thông báo thành công
                        const successMessage = document.createElement('span');
                        successMessage.classList.add('text-success', 'ms-2');
                        successMessage.textContent = 'Sản phẩm đã được thêm vào giỏ hàng!';
                        addToCartButton.parentNode.appendChild(successMessage);

                        // Xóa thông báo thành công sau 3 giây
                        setTimeout(() => {
                            successMessage.remove();
                        }, 3000);
                    })
                    .catch((error) => {
                        variantError.style.display = 'inline'; // Hiển thị lỗi từ server
                        variantError.textContent = error.message;
                    });
            });
            document.querySelectorAll('.variant-option').forEach(button => {
                button.addEventListener('click', function() {
                    // Nếu nút hiện tại đã là bg-secondary, chuyển về bg-white
                    if (this.classList.contains('bg-secondary')) {
                        this.classList.remove('bg-secondary');
                        this.classList.add('bg-white');
                    } else {
                        // Đảm bảo chỉ một nút được chọn, các nút khác chuyển về bg-white
                        document.querySelectorAll('.variant-option').forEach(b => {
                            b.classList.remove('bg-secondary');
                            b.classList.add('bg-white');
                        });

                        // Chuyển nút hiện tại sang bg-secondary
                        this.classList.remove('bg-white');
                        this.classList.add('bg-secondary');
                    }

                    // Ẩn thông báo lỗi nếu người dùng chọn hoặc bỏ chọn biến thể
                    variantError.style.display = 'none';
                });
            });
        });
    </script>
@endsection

@push('scriptStore')
@endpush
