@extends('user.layout.default')
@push('styleStore')
<style>
    body {
        padding-top: 80px; /* Thêm khoảng cách để tránh header che nội dung */
    }
   /* Tùy chỉnh cho tiêu đề */
    h1 {
        font-size: 2.5rem;
        color: #333;
        font-weight: 700;
        margin-bottom: 20px;
        
    }
.ahi{
    font-size: 2.5rem;
        color: #333;
        font-weight: 700;
        margin-bottom: 20px;
        margin-top: 260px;
}
    /* Tùy chỉnh cho hình ảnh */
    .blog-image {
        max-width: 100%;
        height: auto;
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
<div class="container mt-5" >
    <h1 class="ahi">{{ $blog->BlogTitle }}</h1>
    

    <!-- Hình ảnh bài viết -->
    <img src="{{ asset('storage/images/blog/' . $blog->BlogImage) }}" alt="{{ $blog->BlogTitle }}" class="blog-image">

    <!-- Nội dung bài viết -->  
    <div class="blog-content">
        {!! $blog->BlogContent !!}
    </div>

    <!-- Nút quay lại -->
    <a href="{{ route('user.blog.index') }}" class="btn-back">Quay lại danh sách</a>
</div>
@endsection
