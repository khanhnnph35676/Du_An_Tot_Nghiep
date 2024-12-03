@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <!--**********************************
                            Content body start
                        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Cập nhật tài khoản</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Customer</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.customerUpdate', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Thêm phương thức PUT -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cập nhật tài khoản</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listCustomer') }}" class="btn btn-dark mr-3">Quay lại</a>
                                    <button type="submit" class="btn btn-secondary mr-3">Cập nhật</button>
                                </div>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4 ml-4 border">
                                        <!-- Form nhập thông tin khách hàng -->
                                        <div class="form-group">
                                            <label for="name">Họ tên:</label>
                                            <input name="name" class="form-control" type="text" placeholder="Họ tên" readonly
                                                value="{{ old('name', $user->name) }}">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input name="email" class="form-control" type="email" placeholder="Email" readonly
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Địa chỉ:</label>
                                            <input name="phone" class="form-control" type="text" placeholder="Số điện thoại" readonly
                                                value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Mật khẩu:</label>
                                            <input name="password" class="form-control" type="password" readonly
                                                placeholder="Mật khẩu">
                                            <small class="form-text text-muted">Để trống để giữ dòng điện
                                                password.</small>
                                            @error('password')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <!-- Form thêm các thông tin bổ sung -->
                                        <div class="form-group">
                                            <label for="gender">Giới tính:</label>
                                            <div class="basic-form">
                                                <div class="form-group">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="gender" value="male"
                                                            {{ $user->gender == 'male' ? 'checked' : '' }}> Nam
                                                    </label>
                                                    <label class="radio-inline ml-3">
                                                        <input type="radio" name="gender" value="female"
                                                            {{ $user->gender == 'female' ? 'checked' : '' }}> Nữ
                                                    </label>
                                                    <label class="radio-inline ml-3">
                                                        <input type="radio" name="gender" value="other"
                                                            {{ $user->gender == 'other' ? 'checked' : '' }}> Giới tính khác
                                                    </label>
                                                    @error('gender')
                                                        <div class="alert alert-danger"><strong>Lỗi!</strong>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="avatar">Ảnh đại diện:</label>
                                            <div class="image-upload-container">
                                                <img id="imagePreview" src="{{ asset('storage/' . $user->avatar) }}"
                                                    alt="Image Preview"
                                                    style="display:{{ $user->avatar ? 'block' : 'none' }}; width:100px; height:100px;" />
                                                <input type="file" name="avatar" class="form-control-file"
                                                    id="imageUpload" accept="image/*" onchange="previewImage(event)">
                                                <button type="button" class="btn btn-dark" id="removeImage"
                                                    style="display:none;">Remove Image</button>
                                            </div>
                                            @error('avatar')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="birth_date">Ngày sinh:</label>
                                            <input name="birth_date" type="date" class="form-control"
                                                value="{{ old('birth_date', $user->birth_date) }}">
                                            @error('birth_date')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="rule_id">Chức vụ:</label>
                                            <select name="rule_id" class="form-control" required>
                                                @foreach ($rules as $rule)
                                                    <option value="{{ $rule->id }}"
                                                        {{ $user->rule_id == $rule->id ? 'selected' : '' }}>
                                                        {{ $rule->rule_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('rule_id')
                                                <div class="alert alert-danger"><strong>Lỗi!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
                            Content body end
                        ***********************************-->
    <script src="{{ asset('backend/js/product.js') }}"></script>

    <script>
        // Preview hình ảnh avatar
        function previewImage(event) {
            var imagePreview = document.getElementById('imagePreview');
            var removeImage = document.getElementById('removeImage');
            var reader = new FileReader();
            reader.onload = function() {
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
                removeImage.style.display = 'inline';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Xóa hình ảnh
        document.getElementById('removeImage').addEventListener('click', function() {
            document.getElementById('imageUpload').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('removeImage').style.display = 'none';
        });
    </script>
@endsection

@push('scriptHome')
@endpush
