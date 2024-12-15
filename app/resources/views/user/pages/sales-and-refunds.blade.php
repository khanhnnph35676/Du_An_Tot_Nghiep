@extends('user.layout.default')

@section('title', 'Chính Sách Bán Hàng và Hoàn Tiền')

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
        <h1 class="page-title fw-bold text-primary">Chính Sách Bán Hàng & Hoàn Tiền</h1>
        <p class="text-muted">Chúng tôi cam kết mang lại sản phẩm chất lượng và chính sách hỗ trợ minh bạch cho khách hàng.</p>
    </div>
     </div>


    <!-- Nội dung chính -->
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <!-- Chính sách hoàn tiền -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h3 class="card-title text-success">Chính Sách Hoàn Tiền</h3>
                    <p class="card-text">Dưới đây là các điều khoản liên quan đến hoàn tiền:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <strong>Hoàn tiền 100%</strong> nếu sản phẩm bị lỗi từ phía nhà sản xuất.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                            Không chấp nhận hoàn tiền nếu khách hàng đã sử dụng sản phẩm.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-clock-fill text-warning me-2"></i>
                            Yêu cầu hoàn tiền cần được gửi trong vòng <strong>7 ngày</strong> kể từ ngày nhận hàng.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Lưu ý quan trọng -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title text-danger">Lưu Ý Quan Trọng</h4>
                    <p class="card-text">
                        Khách hàng cần cung cấp <strong>hóa đơn mua hàng</strong> hoặc thông tin đặt hàng để chúng tôi có thể xử lý yêu cầu hoàn tiền.
                        Vui lòng kiểm tra kỹ sản phẩm khi nhận hàng để đảm bảo quyền lợi của bạn.
                    </p>
                </div>
            </div>

            <!-- Quy trình hoàn tiền -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title text-info">Quy Trình Hoàn Tiền</h4>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Liên hệ với chúng tôi qua email hoặc hotline để thông báo yêu cầu hoàn tiền.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-receipt-cutoff me-2"></i>
                            Cung cấp hóa đơn mua hàng và hình ảnh sản phẩm bị lỗi (nếu có).
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-box-arrow-in-down me-2"></i>
                            Gửi sản phẩm về địa chỉ của chúng tôi để xác minh.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-cash-coin me-2"></i>
                            Hoàn tiền qua tài khoản ngân hàng hoặc phương thức thanh toán ban đầu trong vòng 3-5 ngày làm việc sau khi xác nhận.
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Liên hệ hỗ trợ -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Liên Hệ Hỗ Trợ</h4>
                    <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn:</p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="bi bi-envelope-fill text-success me-2"></i>
                            Email: <a href="mailto:support@doanvat.com" class="text-decoration-none">khanhnnph35676@fpt.edu.vn</a>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill text-danger me-2"></i>
                            Hotline: <a href="tel:0123456789" class="text-decoration-none">0961746082</a>
                        </li>
                        <li>
                            <i class="bi bi-chat-fill text-info me-2"></i>
                            Chat trực tiếp: Truy cập <a href="/live-chat" class="text-decoration-none">Hỗ trợ trực tuyến</a>.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
