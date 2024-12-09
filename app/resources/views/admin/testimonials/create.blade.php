@extends('admin.layout.default')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Thêm mới đánh giá</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm mới đánh giá</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.StoreTestimonial') }}" method="POST">
                            @csrf
                            <div class="card-header">
                                <h4 class="card-title">Thêm mới đánh giá</h4>
                                <div class="d-flex">
                                    <a href="{{route("admin.testimonials")}}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="user_id">Người dùng</label>
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="content">Nội dung đánh giá</label>
                                    <textarea class="form-control" placeholder="Nhập nội dung" id="content" name="content" rows="3"></textarea>
                                    @error('content')
                                        <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="star">Số sao</label>
                                    <input type="number" class="form-control" id="star" name="rating" min="1"
                                        max="5">
                                    </div>
                                    @error('rating')
                                        <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Danh sách chọn sản phẩm --}}

                                <div id="accordion-four" class="accordion accordion-no-gutter accordion-bordered">
                                    <div class="accordion__item">
                                        <div class="accordion__header collapsed" data-toggle="collapse"
                                            data-target="#bordered_no-gutter_collapseThree">
                                            <span class="accordion__header--text"> Danh sách sản phẩm </span>
                                            <span class="accordion__header--indicator style_two"></span>
                                        </div>
                                        <div id="bordered_no-gutter_collapseThree" class="collapse accordion__body"
                                            data-parent="#accordion-four">
                                            <div class="accordion__body--text">
                                                <div class="table-responsive">
                                                    <table id="example" class="display">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="checkAll"></th>
                                                                <th>Id</th>
                                                                <th>Tên sản phẩm</th>
                                                                <th>Ảnh sản phẩm</th>
                                                                <th>GIá</th>
                                                                <th>Tồn kho</th>
                                                                <th>Lượt xem</th>
                                                                <th>Danh mục</th>
                                                                <th>Loại</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($products as $key => $value)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="product_id[]"
                                                                            value=" {{ $value->id }}" class="checkItem">
                                                                    </td>
                                                                    <td> {{ $value->id }} </td>
                                                                    <td> {{ $value->name }} </td>
                                                                    <td> <img src="{{ asset($value->image) }}"
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            alt="">
                                                                        @php
                                                                            $count = 0;
                                                                        @endphp

                                                                        @foreach ($galleries as $gallerie)
                                                                            @if ($gallerie->product_id == $value->id && $count < 1)
                                                                                <img src="{{ asset($gallerie->image) }}"
                                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                                    alt="">
                                                                                @php
                                                                                    $count++;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                        @if ($count == 1)
                                                                            ...
                                                                        @endif
                                                                    </td>
                                                                    <td> {{ number_format($value->price) }}
                                                                        vnđ </td>
                                                                    <td> {{ $value->qty }} </td>
                                                                    <td> {{ $value->view }} </td>
                                                                    <td> {{ $value->categories ? $value->categories->name : 'No Category' }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($value->type == '1')
                                                                            <span class='badge badge-pill badge-success'>
                                                                                Đơn thể</span>
                                                                        @else
                                                                            <span class='badge badge-pill badge-secondary'>
                                                                                Có biến thể </span>
                                                                        @endif
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
                                @error('product_id')
                                    <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Lắng nghe sự kiện click trên checkbox chính
        document.getElementById('checkAll').addEventListener('click', function(e) {
            // Lấy tất cả các checkbox trong tbody có class là 'checkItem'
            let checkboxes = document.querySelectorAll('.checkItem');

            // Lặp qua các checkbox và đặt giá trị của chúng bằng với checkbox chính
            checkboxes.forEach((checkbox) => {
                checkbox.checked = e.target.checked;
            });
        });
    </script>
@endsection
