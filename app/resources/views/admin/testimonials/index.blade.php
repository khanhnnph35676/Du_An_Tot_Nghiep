@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/testimonial.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Testimonial Management</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Testimonials</h4>
                        <a href="{{ route('admin.createTestimonial') }}" class="btn btn-primary">Add New Testimonial</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Lặp qua tất cả testimonials và hiển thị chúng -->
                            @foreach($testimonials as $testimonial)
                                <div class="col-md-4 mb-4">
                                    <div class="testimonial-card p-3 border">
                                        <!-- Hiển thị ảnh của người dùng -->
                                        <img src="{{ $testimonial->user->avatar ? asset('storage/' . $testimonial->user->avatar) : asset('backend/img/default-user.jpg') }}" alt="User" class="img-fluid rounded-circle mb-3" width="80">
                                        <h5>{{ $testimonial->title }}</h5>
                                        <p class="testimonial-content">{{ $testimonial->description }}</p>
                                        <!-- Hiển thị tên người dùng -->
                                        <h5>By: {{ $testimonial->user->name }}</h5>

                                        <!-- Hiển thị ảnh sản phẩm nếu có -->
                                        @if($testimonial->product_id)
                                            <?php $product = \App\Models\Product::find($testimonial->product_id); ?>
                                            @if($product && $product->image)
                                                <div class="product-image mb-3">
                                                    <img src="{{ Storage::url($product->image) }}" alt="Product Image" class="img-fluid" />
                                                </div>
                                            @endif
                                        @endif

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('admin.editTestimonial', $testimonial->id) }}" class="btn btn-success btn-sm">Edit</a>
                                            <form action="{{ route('admin.deleteTestimonial', $testimonial->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/testimonial.js') }}"></script>
@endsection
