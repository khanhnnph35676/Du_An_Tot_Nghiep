@extends('admin.layout.default')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Cập nhật đánh giá</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Cập nhật đánh giá</a></li>
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
                        <form action="{{ route('admin.updateTestimonial') }}" method="POST">
                            @csrf
                            @method('patch')
                            <input type="number" name="id" value="{{$testimonial->id}}" hidden>
                            <input type="number" name="product_id" value="{{$testimonial->product_id}}" hidden>
                            <input type="number" name="user_id"  value="{{$testimonial->user_id}}" hidden>
                            <div class="card-header">
                                <h4 class="card-title">Cập nhật đánh giá</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.testimonials') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button class="btn btn-primary">Cập nhật</button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="user_id">Người dùng: {{ $testimonial->user->name }}</label>
                                    <p>Email: {{ $testimonial->user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="content">Nội dung đánh giá</label>
                                    <textarea class="form-control" placeholder="Nhập nội dung" id="content" name="content" rows="3">{{ $testimonial->content }}</textarea>
                                    @error('content')
                                        <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="star">Số sao</label>
                                    <input type="number" class="form-control" id="star" name="rating" min="1"
                                        max="5" value="{{ $testimonial->rating }}">
                                    @error('rating')
                                        <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="star">Sản phẩm: {{ $testimonial->product->name }} </label>
                                    <br>
                                    <img src="{{ asset($testimonial->product->image) }}"
                                        style="width: 200px; height: 200px; object-fit: cover;" alt=""
                                        class="rounded">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
