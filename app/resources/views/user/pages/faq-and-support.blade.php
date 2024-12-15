@extends('user.layout.default')

@section('title', 'Câu Hỏi Thường Gặp & Hỗ Trợ')

@section('content')
<style>
    .ahi{
        padding-top: 150px;
    }
</style>
<div class="container mt-5">
   <div class="ahi">
   <div class="text-center mb-5">
        <h1 class="page-title fw-bold text-primary">Câu Hỏi Thường Gặp & Hỗ Trợ</h1>
        <p class="text-muted">Dưới đây là những câu hỏi thường gặp và thông tin hỗ trợ dành cho khách hàng.</p>
    </div>
   </div> <!-- Tiêu đề trang -->
    

    <!-- Phần nội dung chính -->
    <div class="accordion" id="faqAccordion">
        <!-- Câu hỏi 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    1. Tôi có thể đặt hàng như thế nào?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Bạn có thể đặt hàng trực tiếp qua website bằng cách thêm sản phẩm vào giỏ hàng và làm theo hướng dẫn thanh toán. Hoặc liên hệ qua hotline để được hỗ trợ đặt hàng nhanh chóng.
                </div>
            </div>
        </div>

        <!-- Câu hỏi 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    2. Thời gian giao hàng là bao lâu?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Thời gian giao hàng thường mất từ 1-3 ngày làm việc tùy thuộc vào địa điểm giao hàng. Chúng tôi sẽ gửi thông báo chi tiết khi đơn hàng được giao đi.
                </div>
            </div>
        </div>

        <!-- Câu hỏi 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    3. Tôi có thể hủy đơn hàng không?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Có, bạn có thể hủy đơn hàng trước khi đơn hàng được giao đi. Vui lòng liên hệ với chúng tôi qua email hoặc hotline để thực hiện hủy đơn.
                </div>
            </div>
        </div>
    </div>

    <!-- Phần hỗ trợ -->
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-body">
            <h3 class="card-title text-success">Liên Hệ Hỗ Trợ</h3>
            <p>Nếu bạn có thêm thắc mắc hoặc cần hỗ trợ, đừng ngần ngại liên hệ với chúng tôi:</p>
            <ul class="list-unstyled">
                <li>
                    <i class="bi bi-envelope-fill text-primary me-2"></i>
                    Email: <a href="mailto:support@doanvat.com" class="text-decoration-none">support@doanvat.com</a>
                </li>
                <li>
                    <i class="bi bi-telephone-fill text-success me-2"></i>
                    Hotline: <a href="tel:0123456789" class="text-decoration-none">0123-456-789</a>
                </li>
                <li>
                    <i class="bi bi-chat-fill text-warning me-2"></i>
                    Chat trực tiếp: Truy cập <a href="/live-chat" class="text-decoration-none">Hỗ trợ trực tuyến</a>.
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
