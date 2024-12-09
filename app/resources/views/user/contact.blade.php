@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
@endsection
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Liên hệ</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Liên hệ</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Liên Hệ</h1>
                            <p class="mb-4">Mẫu liên hệ hiện tại chưa hoạt động. Bạn có thể tạo một mẫu liên hệ đầy đủ chức năng chỉ trong vài phút với Ajax & PHP. Chỉ cần sao chép và dán tệp, thêm một ít mã và hoàn tất. <a href="https://htmlcodex.com/contact-form">Tải Ngay</a>.</p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe class="rounded w-100"
                                style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1svi!2sbd!4v1694259649153!5m2!1svi!2sbd"
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form action="" class="">
                            <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Họ và Tên của bạn">
                            <input type="email" class="w-100 form-control border-0 py-3 mb-4" placeholder="Nhập Email của bạn">
                            <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Tin nhắn của bạn"></textarea>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary" type="submit">Gửi</button>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Địa Chỉ</h4>
                                <p class="mb-2">1 Trịnh Văn Bô, Nam Từ Liên, Hà Nội</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Email</h4>
                                <p class="mb-2">khanhnnph35676@fpt.edu.vn</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Số Điện Thoại</h4>
                                <p class="mb-2">0148038393</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact End -->
@push('scriptStore')
@endpush
