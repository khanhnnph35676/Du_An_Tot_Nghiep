@extends('user.layout.default')

@push('styleHome')


@endpush

@section('content')

<style>
    body {
        padding-top: 80px; /* Thêm khoảng cách để tránh header che nội dung */
    }
    /* Tùy chỉnh phân trang */
    .pagination {
        justify-content: center; /* Căn giữa phân trang */
        margin-top: 20px; /* Khoảng cách trên */
        text-decoration: #555;
    }
    .page-item .page-link {
        color: #000;  /* Màu sắc của link */
        padding: 10px 20px; /* Thêm padding cho link */
        border-radius: 5px; /* Bo góc */
        transition: background-color 0.3s ease;
        font-weight: bold;
    }
    .page-item.active .page-link {
        /* Màu nền link đang được chọn */
        border-color: #28a745; /* Viền màu */
        color: white; /* Màu chữ */
    }
    .page-item .page-link:hover {
        
        color: white; /* Màu chữ khi hover */
    }

    /* Card Blog */
    .card {
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px); /* Hiệu ứng hover cho card */
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

    .btn-primary {
      
       
    }

    .pagination {
    display: flex; /* Sử dụng flexbox để xếp các phần tử theo hàng ngang */
    justify-content: center; /* Căn giữa phân trang */
    list-style: none; /* Xóa dấu chấm hoặc các biểu tượng trong danh sách */
    margin-top: 20px; /* Khoảng cách phía trên */
}

.pagination .page-item {
    margin: 0 5px; /* Khoảng cách giữa các trang */
}

.pagination .page-link {
    
    padding: 10px 15px; /* Kích thước nút phân trang */
    
    border-radius: 5px; /* Bo góc */
    text-decoration: none; /* Xóa gạch chân */
}

.pagination .page-item.active .page-link {
     /* Màu nền khi trang được chọn */
    border-color: #007bff; /* Viền màu khi trang được chọn */
    color: white; /* Màu chữ khi trang được chọn */
}

.pagination .page-link:hover {
    /* Màu nền khi hover */
    border-color: #0056b3; /* Viền màu khi hover */
    color: white; /* Màu chữ khi hover */
}


    /* Hình ảnh hiển thị đẹp */
    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
<div class="container">
    <h1 class="text-center mb-4">Danh sách bài viết</h1>
    
    <!-- Danh sách bài viết -->
    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/images/blog/' . $blog->BlogImage) }}" class="card-img-top" alt="{{ $blog->BlogTitle}}">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::words(strip_tags($blog->BlogTitle), 5, '...') }}</h5>BlogTitle
                        <p class="card-text">
    {!! Str::words(strip_tags($blog->BlogDesc), 10, '...') !!}</p>

                        <a href="{{ route('user.blog.detail', $blog->BlogSlug) }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    
    
    <div class="pagination-container d-flex justify-content-center align-items-center mt-5">
    <ul class="pagination">
        {{ $blogs->links() }} <!-- Hiển thị phân trang -->
    </ul>
</div>

</div>

</div>
@endsection
