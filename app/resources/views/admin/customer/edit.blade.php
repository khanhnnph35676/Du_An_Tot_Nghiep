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
                        <h4>Hi, welcome back!</h4>
                        <span class="ml-1">Datatable</span>
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
                    <form action="{{ route('admin.customerUpdate', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Thêm phương thức PUT -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Customer</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listCustomer') }}" class="btn btn-dark mr-3">Back</a>
                                </div>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
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
                                            <label for="name">Name:</label>
                                            <input name="name" class="form-control" type="text" placeholder="Name" value="{{ old('name', $user->name) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input name="email" class="form-control" type="email" placeholder="Email" value="{{ old('email', $user->email) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone:</label>
                                            <input name="phone" class="form-control" type="text" placeholder="Phone" value="{{ old('phone', $user->phone) }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input name="password" class="form-control" type="password" placeholder="Password">
                                            <small class="form-text text-muted">Leave blank to keep the current password.</small>
                                        </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <!-- Form thêm các thông tin bổ sung -->
                                        <div class="form-group">
                                            <label for="gender">Gender:</label>
                                            <div class="basic-form">
                                                <div class="form-group">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="gender" value="male" {{ $user->gender == 'male' ? 'checked' : '' }} required> Male
                                                    </label>
                                                    <label class="radio-inline ml-3">
                                                        <input type="radio" name="gender" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}> Female
                                                    </label>
                                                    <label class="radio-inline ml-3">
                                                        <input type="radio" name="gender" value="other" {{ $user->gender == 'other' ? 'checked' : '' }}> Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="avatar">Avatar:</label>
                                            <div class="image-upload-container">
                                                <img id="imagePreview" src="{{ asset('storage/' . $user->avatar) }}" alt="Image Preview" style="display:{{ $user->avatar ? 'block' : 'none' }}; width:100px; height:100px;" />
                                                <input type="file" name="avatar" class="form-control-file" id="imageUpload" accept="image/*" onchange="previewImage(event)">
                                                <button type="button" class="btn btn-dark" id="removeImage" style="display:none;">Remove Image</button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="birth_date">Birth Date:</label>
                                            <input name="birth_date" type="date" class="form-control" value="{{ old('birth_date', $user->birth_date) }}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="rule_id">Role:</label>
                                            <select name="rule_id" class="form-control" required>
                                                <option value="">Select Role</option>
                                                @foreach($rules as $rule)
                                                    <option value="{{ $rule->id }}" {{ $user->rule_id == $rule->id ? 'selected' : '' }}>{{ $rule->rule_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-secondary">Save</button>
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
