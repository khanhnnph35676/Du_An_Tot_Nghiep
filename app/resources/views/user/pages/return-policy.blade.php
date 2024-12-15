@extends('user.layout.default')

@section('title', 'Chính Sách Đổi Trả')

@section('content')
<style>
    .tieude{
        padding-top: 150px;
    }
</style>
<div class="container mt-5">
    <!-- Tiêu đề trang -->
     <div class="tieude">
     <div class="text-center mb-5">
        <h1 class="page-title fw-bold text-danger">Chính Sách Đổi Trả</h1>
        <p class="text-muted">Chúng tôi cam kết mang lại trải nghiệm mua sắm hài lòng nhất cho khách hàng.</p>
    </div>

     </div>

    <!-- Nội dung chính -->
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <!-- Điều kiện đổi trả -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h3 class="card-title text-primary">Điều Kiện Đổi Trả</h3>
                    <p class="card-text">Chúng tôi hỗ trợ đổi trả trong các trường hợp sau:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-exclamation-circle-fill text-danger me-2"></i>
                            Sản phẩm giao sai hoặc bị lỗi.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-calendar-check-fill text-success me-2"></i>
                            Yêu cầu đổi trả được thực hiện trong vòng <strong>7 ngày</strong> kể từ ngày nhận hàng.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-box-seam text-warning me-2"></i>
                            Sản phẩm còn nguyên bao bì, chưa qua sử dụng.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Lưu ý quan trọng -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title text-danger">Lưu Ý Quan Trọng</h4>
                    <p>Khách hàng vui lòng giữ <strong>hóa đơn mua hàng</strong> để tiện xử lý đổi trả. Hóa đơn là cơ sở xác minh giao dịch và sản phẩm.</p>
                </div>
            </div>

            <!-- Quy trình đổi trả -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title text-success">Quy Trình Đổi Trả</h4>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">
                            <i class="bi bi-box-arrow-in-down me-2"></i>
                            Liên hệ với chúng tôi qua email hoặc hotline để thông báo yêu cầu đổi trả.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-arrow-left-right me-2"></i>
                            Đóng gói sản phẩm cẩn thận, đảm bảo còn nguyên bao bì.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-truck me-2"></i>
                            Gửi sản phẩm về địa chỉ đổi trả của chúng tôi qua đơn vị vận chuyển.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-cash-stack me-2"></i>
                            Sau khi xác minh, chúng tôi sẽ hoàn tiền hoặc gửi sản phẩm thay thế theo yêu cầu.
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Liên hệ hỗ trợ -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-info">Liên Hệ Hỗ Trợ</h4>
                    <p>Để đổi trả hoặc được hỗ trợ thêm, vui lòng liên hệ:</p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            Email: <a href="mailto:support@doanvat.com" class="text-decoration-none">khanhnnph35676@fpt.edu.vn</a>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill text-success me-2"></i>
                            Hotline: <a href="tel:0123456789" class="text-decoration-none">0961746082</a>
                        </li>
                        <li>
                            <i class="bi bi-chat-fill text-warning me-2"></i>
                            Chat trực tiếp: Truy cập <a href="#" class="text-decoration-none">Hỗ trợ trực tuyến</a>.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
