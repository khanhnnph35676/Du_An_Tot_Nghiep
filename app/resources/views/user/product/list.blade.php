@extends('user.layout.default')

@push('styleHome')
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Danh sách sản phẩm</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Danh sách sản phẩm</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Đồ ăn vặt tuổi thơ shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">

                    <div class="row g-4 mt-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Danh mục</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a
                                                            href="{{ route('storeListProduct', ['category_id' => $category->id]) }}">
                                                            <i class="fas fa-apple-alt me-2"></i>{{ $category->name }}
                                                        </a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-xl-12">
                                        <!-- Form tìm kiếm -->
                                        <form action="{{ route('storeListProduct') }}" method="GET" class="d-flex">
                                            <input type="text" name="search" class="form-control p-3"
                                                placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary ms-2"><i
                                                    class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="col-xl-12">
                                        <!-- Form lọc giá -->
                                        <form action="{{ route('storeListProduct') }}" method="GET" class="d-flex">
                                            <input type="number" name="price" class="form-control p-3"
                                                placeholder="Lọc theo giá (VNĐ)" value="{{ request('price') }}">
                                            <button class="btn btn-secondary ms-2" style="min-width: 80px;">Lọc giá</button>
                                        </form>
                                        <p class="mt-3">Lọc các sản phẩm dưới giá nhập</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                @foreach ($products as $product)
                                    <div class="col-md-6 col-lg-6 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                                                    <img src="{{ asset($product->image) }}"
                                                        style="height: 170px; object-fit: cover; border: 1px solid #ddd;"
                                                        class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom " style="height:170px;">
                                                <p class="text-dark  fw-bold">
                                                    {{ Str::words(strip_tags($product->name), 3, '...') }}</p>
                                                <p class="text-dark fw-bold">{{ number_format($product->price) }} Vnđ</p>
                                                <!-- Giới hạn 6 chữ --> <!-- Giới hạn 6 chữ -->
                                                <div class="variant d-flex flex-wrap">
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
                                                    <input type="hidden" id="optionValueInput{{ $product->id }}"
                                                        name="product_variant_id" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-12">
                                    <div class="pagination d-flex justify-content-center mt-5">
                                        {{ $products->links() }} <!-- Hiển thị phân trang -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection

@push('scriptHome')
@endpush
