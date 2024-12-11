@extends('user.layout.default')
@push('styleStore')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .info-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-edit {
            margin-top: 20px;
            width: 100%;
        }

        .side-bar {
            min-height: 300px;
        }

        .side-bar li {
            display: block;
            border-bottom: 1px solid black;
        }

        .side-bar li:hover {
            background: #b9b7b793;
        }
    </style>
@endpush
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thông tin cá nhân</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{route('storeHome')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Thông tin cá nhân</li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    @php
        $count = 0;
    @endphp
    @foreach ($orderLists as $item)
        @if ($item->orders->status != 5)
            @php
                $count += 1;
            @endphp
        @endif
    @endforeach
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <ul class="side-bar border rounded p-1">
                    <h3 class="mb-4 mt-3 ms-3">Đơn Hàng</h3>
                    <li class="p-2 mt-2"><a href="{{ route('user.profile') }}" class="text-dark"><strong>Thông tin cá
                                nhân</strong> </a> </li>

                    <li class="p-2 mt-2"><a href="{{ route('order.history') }}" class="text-dark"><strong>Đơn hàng
                                ({{ $count }})</strong>
                        </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('points') }}" class="text-dark"><strong>Điểm thưởng</strong>
                    </a> </li>
                </ul>
            </div>
            <div class="col-lg-9 m-0 p-0">
                <div class="content m-0">
                    <div class="profile-header">
                        @if ($user->avatar == null)
                            <img src="{{ asset('storage/avatars/OIP.jpg') }}">
                        @else
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="" style="object-fit: cover;">
                        @endif

                        <div>
                            <h2>{{ $user->name }}</h2>
                            <p class="text-muted">Email: {{ $user->email }}</p>
                            <p class="text-muted">Phone: {{ $user->phone }}</p>
                            <p class="text-muted">Giới tính: {{ $user->gender }}</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <h5>Thông tin cá nhân</h5>
                        @foreach ($address as $value)
                            <p><strong>Địa chỉ: </strong> {{ $value->address }}</p>
                            <p><strong>Số nhà: </strong>{{ $value->home_address }}</p>
                        @endforeach
                    </div>
                    <div class="text-end" >
                    <button class="btn btn-primary  " data-bs-toggle="modal" data-bs-target="#editProfileModal">Sửa
                    thông tin</button>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Chỉnh Sửa Hồ Sơ -->
    <!-- Modal Chỉnh Sửa Hồ Sơ và Địa Chỉ -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Sửa thông tin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- {{ route('user.profile.update') }} --}}
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Thông tin cá nhân -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Nhập tên">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Nhập email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>

                    <!-- Sửa địa chỉ -->

                    @foreach ($address as $key => $value)
                    <div class="mb-3">
    <label for="address" class="form-label">Địa chỉ</label>
    <input type="text" class="form-control" id="address" name="address"
           value="{{ optional($address->first())->address }}" placeholder="Nhập địa chỉ">
</div>
<div class="mb-3">
    <label for="home_address" class="form-label">Số nhà</label>
    <input type="text" class="form-control" id="home_address" name="home_address"
           value="{{ optional($address->first())->home_address }}" placeholder="Nhập số nhà">
</div>

@endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scriptStore')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
@endpush
