@extends('user.layout.default')

@section('title', 'Chính Sách Bảo Mật')

@section('content')
<style>
.banner{
    padding-top: 150px;
}
</style>
<div class="container mt-5">
    <div class="banner">
    <div class="text-center mb-4">
        <h1 class="page-title fw-bold text-warning">Chính Sách Bảo Mật</h1>
        <p class="text-muted">Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn khi sử dụng dịch vụ tại Đồ Ăn Vặt.</p>
    </div>
    </div>
    
    
    <!-- Nội dung chính -->
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <!-- Section Giới thiệu -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h3 class="card-title text-primary">Cam Kết Của Chúng Tôi</h3>
                    <p class="card-text">Dưới đây là những thông tin cụ thể về chính sách bảo mật của chúng tôi:</p>
                </div>
            </div>
            
            <!-- Các cam kết chi tiết -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Thu thập và sử dụng thông tin cá nhân chỉ nhằm mục đích cung cấp dịch vụ.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-lock-fill text-danger me-2"></i>
                            Bảo mật thông tin khách hàng và không chia sẻ cho bên thứ ba nếu không có sự đồng ý.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-pencil-square text-info me-2"></i>
                            Khách hàng có quyền yêu cầu xóa hoặc chỉnh sửa thông tin của mình.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Liên hệ -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-warning">Liên Hệ</h4>
                    <p class="card-text">Hãy liên hệ với chúng tôi nếu bạn có bất kỳ thắc mắc nào.</p>
                    <p>
                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                        Email: <a href="mailto:support@doanvat.com" class="text-decoration-none">support@doanvat.com</a>
                    </p>
                    <p>
                        <i class="bi bi-telephone-fill text-success me-2"></i>
                        Hotline: <a href="tel:0123456789" class="text-decoration-none">0123-456-789</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
