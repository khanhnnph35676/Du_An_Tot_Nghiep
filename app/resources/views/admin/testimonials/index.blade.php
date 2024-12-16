@extends('admin.layout.default')

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/testimonial.css') }}">

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Danh sách đánh giá</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Danh sách sản phẩm</a></li>
                    </ol>
                </div>
            </div>
            @if (session('message'))
                <div class="message">
                    <div class="alert alert-primary alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                    class="mdi mdi-close"></i></span>
                        </button>
                        @if (session('message'))
                            <strong>{{ session('message') }}</strong>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Danh sách đánh giá</h4>
                            <a href="{{ route('admin.createTestimonial') }}" class="btn btn-primary">Thêm mới</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Người dùng</th>
                                            <th>Sản phẩm</th>
                                            <th>Nội dung</th>
                                            <th>Số sao</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($testimonials as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($value->user->avatar != null)
                                                        <img src="{{ asset('storage/' . $value->user->avatar) }}"class="rounded-pill mr-2"
                                                            style="width: 42px; height: 42px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('storage/avatars/OIP.jpg') }}"
                                                            class="rounded mr-2"
                                                            style="width: 42px; height: 42px; object-fit: cover;">
                                                    @endif
                                                    {{ $value->user->email }}
                                                </td>
                                                <td>
                                                    @if ($value->product != null)
                                                        <img src="{{ asset($value->product->image) }}"
                                                            style="width: 50px; height: 50px; object-fit: cover;" alt=""
                                                            class="rounded">
                                                        {{ $value->product->name }}
                                                    @endif
                                                </td>
                                                </td>
                                                <td>
                                                    {{ $value->content }}
                                                </td>
                                                <td>{{ $value->rating }}</td>
                                                <td>
                                                    <a href="{{ route('admin.editTestimonial', ['id' => $value->id]) }}"
                                                        class="btn btn-secondary"> Xem chi tiết</a>
                                                    {{-- <button type="button" class="btn btn-dark" data-toggle="modal"
                                                        data-target="#deleteTestimonial"
                                                        data-id="{{ $value->id }}">Xoá</button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deleteTestimonial">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thông báo</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="formDelete">
                        @method('delete')
                        @csrf
                        <div class="modal-body">
                            <p>Bạn có muốn xoá đánh giá này không?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Xoá</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('focus-2/focus-2/documentation/main/assets/js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/testimonial.js') }}"></script>
    <script>
        $('#deleteTestimonial').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút kích hoạt modal
            var id = button.data('id'); // Lấy giá trị từ thuộc tính data-id
            var modal = $(this); // Khai báo modal
            var formDelete = modal.find('#formDelete'); // Tìm form bên trong modal
            formDelete.attr('action', '{{ route('admin.deleteTestimonial') }}?id=' +
                id); // Thiết lập action cho form
        });
    </script>
@endsection
