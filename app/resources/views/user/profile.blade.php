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
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
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
                    <h3 class="mb-4 mt-3 ms-3">Thông tin cá nhân</h3>
                    <li class="p-2 mt-2"><a href="{{ route('user.profile') }}" class="text-dark"><strong>Thông tin cá
                                nhân</strong> </a> </li>

                    <li class="p-2 mt-2"><a href="{{ route('order.history') }}" class="text-dark"><strong>Đơn hàng
                                ({{ $count }})</strong>
                        </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('points') }}" class="text-dark"><strong>Điểm thưởng</strong>
                        </a> </li>
                    <li class="p-2 mt-2"><a href="{{ route('user.change-password') }}" class="text-dark"><strong>Đổi mật
                                khẩu</strong>
                        </a> </li>
                </ul>
            </div>
            <div class="col-lg-9 m-0 p-0">
                <div class="content m-0">
                    <div class="profile-header">
                    @if ($user->avatar == null)
    <img src="{{ asset('storage/avatars/default.jpg') }}" alt="Default Avatar" style="object-fit: cover;">
@else
    <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Avatar" style="object-fit: cover;">
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
                        @foreach ($address as $key => $value)
                            <div class="d-flex align-items-center" id="address-row-{{ $value->id }}">
                                <span class="m-3"><strong>Địa chỉ {{ $key + 1 }}: </strong>
                                    {{ $value->home_address . ', ' . $value->address }}</span>
                                <button class="btn btn border delete-address" type="button"
                                    data-id="{{ $value->id }}">Xóa</button>
                            </div>
                        @endforeach

                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                            data-bs-target="#add_address">Thêm</button>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Sửa
                            thông tin</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Thêm địa chỉ  --}}
    <div class="modal fade" id="add_address" tabindex="-1" aria-labelledby="addAddressModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addAddressModel">Thêm mới địa chi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="address-form">
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <label class="form-label my-3">Tỉnh/Thành phố<sup>*</sup></label>
                                    <select name="province" id="province" class="form-control"></select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label class="form-label my-3">Quận/Huyện<sup>*</sup></label>
                                    <select name="district" id="district" class="form-control"></select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label class="form-label my-3">Xã/Phường<sup>*</sup></label>
                                    <select name="ward" id="ward" class="form-control"></select>
                                </div>
                                <div class="col-md-12 col-lg-8">
                                    <label class="form-label my-3">Địa chỉ nhà:<sup>*</sup></label>
                                    <div class="form-item w-100 d-flex">
                                        <input type="text" class="form-control me-2" placeholder="Địa chỉ"
                                            name="home_address" id="home_address">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button id="save-address" type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Chỉnh Sửa Hồ Sơ -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Sửa thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- {{ route('user.profile.update') }} --}}
                <form action="{{route('updateProfile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="modal-body">
                        <!-- Thông tin cá nhân -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" placeholder="Nhập tên">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email"  disabled
                                value="{{ $user->email }}" placeholder="Nhập email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $user->phone }}" placeholder="Nhập số điện thoại">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let provinceList = {};
        let districtList = {};
        let wardList = {};
        // Lấy danh sách tỉnh/thành phố
        fetch('https://provinces.open-api.vn/api/p/')
            .then(response => response.json())
            .then(data => {
                let provinceSelect = document.getElementById('province');
                provinceSelect.innerHTML = '<option value="">Chọn Tỉnh/Thành phố</option>';
                data.forEach(province => {
                    provinceList[province.code] = province.name; // Lưu tên tỉnh
                    let option = document.createElement('option');
                    option.value = province.code;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
            });

        // Khi chọn tỉnh/thành phố, lấy danh sách quận/huyện
        document.getElementById('province').addEventListener('change', function() {
            let provinceCode = this.value;
            if (provinceCode) {
                fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                    .then(response => response.json())
                    .then(data => {
                        let districtSelect = document.getElementById('district');
                        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                        data.districts.forEach(district => {
                            districtList[district.code] = district.name; // Lưu tên quận
                            let option = document.createElement('option');
                            option.value = district.code;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });

                        // Xóa danh sách xã/phường
                        document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
                    });
            } else {
                // Xóa các danh sách khi không chọn tỉnh/thành phố
                document.getElementById('district').innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
            }
        });
        // Khi chọn quận/huyện, lấy danh sách xã/phường
        document.getElementById('district').addEventListener('change', function() {
            let districtCode = this.value;
            if (districtCode) {
                fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => response.json())
                    .then(data => {
                        let wardSelect = document.getElementById('ward');
                        wardSelect.innerHTML = '<option value="">Chọn Xã/Phường</option>';
                        data.wards.forEach(ward => {
                            wardList[ward.code] = ward.name; // Lưu tên xã
                            let option = document.createElement('option');
                            option.value = ward.code;
                            option.textContent = ward.name;
                            wardSelect.appendChild(option);
                        });
                    });
            } else {
                // Xóa danh sách xã/phường khi không chọn quận/huyện
                document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
            }
        });
        // Khi lưu địa chỉ, thay mã bằng tên
        document.getElementById('save-address').addEventListener('click', function(e) {
            e.preventDefault();
            const provinceCode = document.getElementById('province').value;
            const districtCode = document.getElementById('district').value;
            const wardCode = document.getElementById('ward').value;
            const homeAddress = document.getElementById('home_address').value;

            // Lấy tên tỉnh, quận, xã từ mã đã lưu
            const provinceName = provinceList[provinceCode];
            const districtName = districtList[districtCode];
            const wardName = wardList[wardCode];

            fetch('/address', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: JSON.stringify({
                        province: provinceName,
                        district: districtName,
                        ward: wardName,
                        home_address: homeAddress,
                    }),
                })
                .then((response) => response.json())
                .then(location.reload())

        });
        // Xóa địa chỉ khi nhấn nút "Xóa"
        document.querySelectorAll('.delete-address').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn trình duyệt reload lại trang

                const addressId = this.getAttribute('data-id'); // Lấy ID của địa chỉ
                const addressRow = document.getElementById(
                `address-row-${addressId}`); // Tìm hàng tương ứng

                // Xóa hàng khỏi DOM
                if (addressRow) {
                    addressRow.remove();
                }
            });
        });

        document.querySelectorAll('.delete-address').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn reload trang

                const addressId = this.getAttribute('data-id'); // Lấy ID của địa chỉ
                const addressRow = document.getElementById(
                    `address-row-${addressId}`); // Tìm dòng tương ứng

                // Gửi yêu cầu xóa
                fetch(`/address/${addressId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            addressRow.remove(); // Xóa dòng khỏi giao diện
                        } else {
                            alert(data.message); // Báo lỗi
                        }
                    })
            });
        });
    </script>
@endsection

@push('scriptStore')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
@endpush
