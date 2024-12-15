@extends('user.layout.default')

@section('title', 'Điều Khoản Sử Dụng')

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
        <h1 class="page-title fw-bold text-warning">Điều Khoản Sử Dụng</h1>
        <p class="text-muted">Bằng việc sử dụng dịch vụ tại <strong>Đồ Ăn Vặt</strong>, bạn đồng ý tuân thủ các điều khoản dưới đây.</p>
    </div>
    </div>


    <!-- Nội dung điều khoản -->
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h3 class="card-title text-primary">Điều Khoản Cơ Bản</h3>
                    <p class="card-text">Dưới đây là các điều khoản mà người dùng cần tuân thủ:</p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">
                            <i class="bi bi-shield-lock-fill text-danger me-2"></i>
                            <strong>Không sử dụng dịch vụ vào mục đích bất hợp pháp:</strong> Mọi hành vi vi phạm pháp luật thông qua nền tảng của chúng tôi đều bị nghiêm cấm.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-people-fill text-success me-2"></i>
                            <strong>Tôn trọng quyền lợi và sự riêng tư của các khách hàng khác:</strong> Mọi hành vi quấy rối, xâm phạm dữ liệu cá nhân sẽ bị xử lý.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                            <strong>Đảm bảo thông tin cung cấp là chính xác và trung thực:</strong> Khách hàng chịu trách nhiệm với các thông tin đã cung cấp.
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Quyền và trách nhiệm của chúng tôi -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title text-danger">Quyền Của Chúng Tôi</h4>
                    <p>
                        <i class="bi bi-exclamation-circle-fill text-danger me-2"></i>
                        Chúng tôi có quyền thay đổi, chỉnh sửa, hoặc cập nhật các điều khoản bất kỳ lúc nào mà không cần báo trước.
                        Các thay đổi sẽ có hiệu lực ngay khi được cập nhật trên hệ thống.
                    </p>
                </div>
            </div>

            <!-- Lưu ý quan trọng -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title text-success">Lưu Ý Quan Trọng</h4>
                    <p>
                        Việc tiếp tục sử dụng dịch vụ sau khi có thay đổi đồng nghĩa với việc bạn chấp nhận các điều khoản mới.
                        Nếu bạn có bất kỳ thắc mắc nào về điều khoản, vui lòng liên hệ với chúng tôi để được giải đáp.
                    </p>
                </div>
            </div>

            <!-- Liên hệ hỗ trợ -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-primary">Liên Hệ Hỗ Trợ</h4>
                    <p>Để biết thêm chi tiết hoặc có bất kỳ thắc mắc nào, bạn có thể liên hệ với chúng tôi qua:</p>
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
                            Chat trực tiếp: Truy cập <a href="#" class="text-decoration-none">Hỗ trợ trực tuyến</a>.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
