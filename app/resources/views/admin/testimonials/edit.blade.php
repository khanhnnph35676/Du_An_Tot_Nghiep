@extends('admin.layout.default')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Edit Testimonial</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Testimonial</h4>
                        </div>
                        <div class="card-body">
                            <!-- Form để chỉnh sửa testimonial -->
                            <form action="{{ route('admin.updateTestimonial', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $testimonial->title) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $testimonial->description) }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="user_id">User</label>
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $testimonial->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select class="form-control" id="product_id" name="product_id" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $product->id == $testimonial->product_id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="star">Rating</label>
                                    <input type="number" class="form-control" id="star" name="star" min="1" max="5" value="{{ old('star', $testimonial->star) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1" {{ $testimonial->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $testimonial->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                    <!-- Hiển thị ảnh sản phẩm nếu có -->
                                    @if($testimonial->product && $testimonial->product->image)
                                        <img src="{{ asset('storage/' . $testimonial->product->image) }}" alt="Product Image" class="img-fluid mb-3" width="100">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
