@extends('user.layout.default')

@push('styleHome')
@endpush

@section('content')
    <style>
        /* Tùy chỉnh phân trang */
        .pagination {
            justify-content: center;
            /* Căn giữa phân trang */
            margin-top: 20px;
            /* Khoảng cách trên */
            text-decoration: #555;
        }

        .page-item .page-link {
            color: #000;
            /* Màu sắc của link */
            padding: 10px 20px;
            /* Thêm padding cho link */
            border-radius: 5px;
            /* Bo góc */
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .page-item.active .page-link {
            /* Màu nền link đang được chọn */
            border-color: #28a745;
            /* Viền màu */
            color: white;
            /* Màu chữ */
        }

        .page-item .page-link:hover {

            color: white;
            /* Màu chữ khi hover */
        }

        /* Card Blog */
        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            /* Hiệu ứng hover cho card */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        .card-body p {
            color: #555;
        }

        .btn-primary {}

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .pagination .page-item.active .page-link {
            border-color: #00ff22;
            color: white;
        }

        .pagination .page-link:hover {
            border-color: #00b312;
            color: white;
        }

        /* Hình ảnh hiển thị đẹp */
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .small {
            direction: none;
        }
    </style>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Bài viết</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item active text-white">Bài viết</li>
        </ol>
    </div>
    <!-- Order History Start -->
    <div class="container mt-5">
        <!-- Danh sách bài viết -->
        <div class="row">
            <div class="col-3 border rounded">
                <h2 class="mb-4 mt-4">Bài viết nổi bật</h2>
            </div>
            <div class="ms-3 pe-5 ps-5 col-8 border rounded">
                <div class="row">
                    <h2 class="mb-4 mt-4">Danh sách bài viết</h2>
                    @foreach ($blogs as $blog)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/images/blog/' . $blog->BlogImage) }}" class="card-img-top"
                                    alt="{{ $blog->BlogTitle }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::words(strip_tags($blog->BlogTitle), 8, '...') }}</h5>
                                    <p class="card-text">
                                        {!! Str::words(strip_tags($blog->BlogDesc), 10, '...') !!}</p>

                                    <a href="{{ route('user.blog.detail', $blog->BlogSlug) }}" class="btn btn-primary">Xem
                                        chi
                                        tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-container d-flex justify-content-center align-items-center mt-2">
                    <ul class="pagination">
                        {{ $blogs->links() }}
                    </ul>
                    <style>
                        .pagination-summary,
                        .pagination-info {
                            display: none !important;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
