@extends('user.layout.default')
@push('styleStore')
    <style>
        h1 {
            font-size: 2.5rem;
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;

        }

        .ahi {
            font-size: 2.5rem;
            color: #333;
            font-weight: 700;
        }

        /* Tùy chỉnh cho hình ảnh */
        .blog-image {
            width: 30%;
            height: 30%;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        /* Cải thiện độ đọc dễ dàng cho nội dung */
        .blog-content {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            margin-bottom: 30px;
        }

        /* Cải thiện kiểu dáng cho nút quay lại */
        .btn-back {

            font-size: 1.1rem;
            background-color: #28a745;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #218838;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Nội dung bài viết</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.blog.index') }}">Bài viết</a></li>
            <li class="breadcrumb-item active text-white">Nội dung bài viết</li>
        </ol>
    </div>
    <div class="container mt-5 border rounded p-4">
        <h1 class="ahi">{{ $blog->BlogTitle }}</h1>
        <img src="{{ asset('storage/images/blog/' . $blog->BlogImage) }}" alt="{{ $blog->BlogTitle }}" class="blog-image">
        <div class="blog-content">
            {!! $blog->BlogContent !!}
        </div>
        <a href="{{ route('user.blog.index') }}" class="btn-back">Quay lại </a>
    </div>
@endsection
