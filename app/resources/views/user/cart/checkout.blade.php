@extends('user.layout.default')
@push('styleStore')
@endpush
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thanh toán</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item text-white"><a href="{{ route('storeListCart') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active text-white">Thanh toán</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Billing details</h1>
            <form action="{{ route('AddOrder') }}" method="POST">
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Họ tên<sup>*</sup></label>
                                    <input type="text" class="form-control"
                                        value="{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}"
                                        placeholder="Họ tên">
                                </div>
                            </div>
                        </div>
                        @php
                            $countAddresses = 0;
                            $address_id = null;
                        @endphp
                        @if (isset($address))
                            @foreach ($address as $key => $item)
                                <div class="row address-item" id="address-row-{{ $item['id'] }}">
                                    <label class="form-label my-3">Địa chỉ {{ $key + 1 }}:<sup>*</sup></label>
                                    <div class="form-item d-flex align-items-center">
                                        <!-- Radio để chọn địa chỉ -->
                                        <input type="radio" name="selected_address" id="address-{{ $item['id'] }}"
                                            value="{{ $item['id'] }}" class="me-2" {{ $key === 0 ? 'checked' : '' }}>

                                        <!-- Hiển thị địa chỉ -->
                                        <input type="text" class="form-control me-2" placeholder="Địa chỉ"
                                            value="{{ $item['home_address'] . ', ' . $item['address'] }}" readonly>

                                        <!-- Nút chọn -->
                                        <button class="btn btn-primary select-address me-2"
                                            data-id="{{ $item['id'] }}">Chọn</button>

                                        <!-- Nút xóa -->
                                        <button class="btn btn-danger delete-address"
                                            data-id="{{ $item['id'] }}">Xóa</button>
                                    </div>
                                </div>
                            @endforeach
                            <button class="btn btn-primary mt-3" id="add-address">Thêm địa chỉ mới</button>
                        @endif
                        <div id="address-form" style="display: none;">
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
                                        <button class="btn btn-primary" id="save-address">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại<sup>*</sup></label>
                            <input type="tel" class="form-control" placeholder="Số điện thoại"
                                value="{{ isset(Auth::user()->phone) ? Auth::user()->phone : '' }}">
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Địa chỉ Email<sup>*</sup></label>
                            <input type="email" class="form-control" placeholder="Email"
                                value="{{ isset(Auth::user()->email) ? Auth::user()->email : '' }}">
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Products</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $sumPrice = 0;
                                    @endphp
                                    @if (Auth::check())
                                        @foreach ($products as $product)
                                            @foreach ($cart as $item)
                                                @if ($product->id == $item['product_id'] && $product->type === '1' && Auth::id() == $item['user_id'])
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="d-flex align-items-center">
                                                                <img src=" {{ asset($product->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </div>
                                                        </th>
                                                        <td>
                                                            {{ $product->name }}
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 mt-4">{{ number_format($product->price) }}</p>
                                                        </td>
                                                        <td>
                                                            <div class="input-group quantity mt-4" style="width: 100px;">
                                                                <div class="input-group-btn">
                                                                    <button
                                                                        class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                                <input type="text"
                                                                    class="form-control form-control-sm text-center border-0"
                                                                    value="{{ $item['qty'] }}">
                                                            </div>
                                                        </td>
                                                @endif
                                                @foreach ($productVariants as $productVariant)
                                                    @if (
                                                        $product->id == $item['product_id'] &&
                                                            $item['product_variant_id'] == $productVariant->id &&
                                                            Auth::id() == $item['user_id']
                                                    )
                                                        @php
                                                            $sumPrice += $productVariant->price;
                                                        @endphp
                                                        <tr>
                                                            <th scope="row">
                                                                <div class="d-flex align-items-center">
                                                                    <img src=" {{ asset($productVariant->image) }}"
                                                                        class="img-fluid me-5 rounded-circle"
                                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                                        alt="Ảnh sản phẩm">

                                                                </div>
                                                            </th>
                                                            <td>
                                                                {{ $product->name . ' - ' . $productVariant->sku }}
                                                            </td>
                                                            <td>
                                                                <p class="mb-0 mt-4">
                                                                    {{ number_format($productVariant->price) }}</p>
                                                                <input type="text" name='price'
                                                                    value="{{ $productVariant->price }}" hidden>
                                                            </td>
                                                            <td>
                                                                <div class="input-group quantity mt-4"
                                                                    style="width: 100px;">
                                                                    <div class="input-group-btn">
                                                                        <button
                                                                            class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm text-center border-0"
                                                                        value="{{ $item['qty'] }}">
                                                                    <div class="input-group-btn">
                                                                        <button
                                                                            class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="mb-0 text-dark py-4">Shipping</p>
                                        </td>
                                        <td colspan="3" class="py-5">
                                            <div class="form-check text-start">
                                            </div>
                                            <div class="form-check text-start">
                                                <label class="form-check-label" for="Shipping-2">Flat rate: 15.000
                                                    vnđ</label>
                                            </div>
                                            <div class="form-check text-start">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                        </td>
                                        <td class="py-5"></td>
                                        <td class="py-5">
                                            <div class="border-bottom border-top">
                                                <p class="m-2 text-dark">{{ number_format($sumPrice + 15000) }} vnđ</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Transfer-1"
                                        name="Transfer" value="Transfer">
                                    <label class="form-check-label" for="Transfer-1">Direct Bank Transfer</label>
                                </div>
                                <p class="text-start text-dark">Make your payment directly into our bank account. Please
                                    use your Order ID as the payment reference. Your order will not be shipped until the
                                    funds have cleared in our account.</p>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Payments-1"
                                        name="Payments" value="Payments">
                                    <label class="form-check-label" for="Payments-1">Check Payments</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Delivery-1"
                                        name="Delivery" value="Delivery">
                                    <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Paypal-1"
                                        name="Paypal" value="Paypal">
                                    <label class="form-check-label" for="Paypal-1">Paypal</label>
                                </div>
                            </div>
                        </div>
                        @php
                            print_r($cart);
                        @endphp
                        <input type="text" name='sum_price' value="{{ $sumPrice + 15000 }}" hidden>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">
                                Place Order
                            </button>
                        </div>
            </form>
        </div>
    </div>

    </div>
    </div>
    <!-- Checkout Page End -->
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
                        document.getElementById('ward').innerHTML =
                            '<option value="">Chọn Xã/Phường</option>';
                    });
            } else {
                // Xóa các danh sách khi không chọn tỉnh/thành phố
                document.getElementById('district').innerHTML =
                    '<option value="">Chọn Quận/Huyện</option>';
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

        // // Khi lưu địa chỉ, thay mã bằng tên
        // document.getElementById('save-address').addEventListener('click', function(e) {
        //     e.preventDefault();
        //     const provinceCode = document.getElementById('province').value;
        //     const districtCode = document.getElementById('district').value;
        //     const wardCode = document.getElementById('ward').value;
        //     const homeAddress = document.getElementById('home_address').value;

        //     // Lấy tên tỉnh, quận, xã từ mã đã lưu
        //     const provinceName = provinceList[provinceCode];
        //     const districtName = districtList[districtCode];
        //     const wardName = wardList[wardCode];

        //     // In ra kết quả
        //     console.log({
        //         province: provinceName,
        //         district: districtName,
        //         ward: wardName,
        //         homeAddress
        //     });

        //     fetch('/address', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                     'content'),
        //             },
        //             body: JSON.stringify({
        //                 province: provinceName,
        //                 district: districtName,
        //                 ward: wardName,
        //                 home_address: homeAddress,
        //             }),
        //         })
        //         .then((response) => response.json())
        //         .then((data) => {
        //             if (data.success) {
        //                 alert(data.message);
        //                 document.getElementById('address-form').style.display = 'none';
        //             } else {
        //                 alert(data.message);
        //             }
        //         });
        // });

        // // Xóa địa chỉ khi nhấn nút "Xóa"
        // document.querySelectorAll('.delete-address').forEach(function(button) {
        //     button.addEventListener('click', function(e) {
        //         e.preventDefault(); // Ngăn trình duyệt reload lại trang

        //         const addressId = this.getAttribute('data-id'); // Lấy ID của địa chỉ
        //         const addressRow = document.getElementById(
        //             `address-row-${addressId}`); // Tìm hàng tương ứng

        //         // Xóa hàng khỏi DOM
        //         if (addressRow) {
        //             addressRow.remove();
        //         }

        //         // Nếu tất cả địa chỉ bị xóa, có thể hiển thị thông báo
        //         const remainingAddresses = document.querySelectorAll('.address-item');
        //         if (remainingAddresses.length === 0) {
        //             alert('Tất cả địa chỉ đã bị xóa!');
        //         }
        //     });
        // });
        // document.querySelectorAll('.delete-address').forEach(function(button) {
        //     button.addEventListener('click', function(e) {
        //         e.preventDefault(); // Ngăn reload trang

        //         const addressId = this.getAttribute('data-id'); // Lấy ID của địa chỉ
        //         const addressRow = document.getElementById(
        //             `address-row-${addressId}`); // Tìm dòng tương ứng

        //         // Gửi yêu cầu xóa
        //         fetch(`/address/${addressId}`, {
        //                 method: 'DELETE',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
        //                         .getAttribute('content')
        //                 }
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.success) {
        //                     addressRow.remove(); // Xóa dòng khỏi giao diện
        //                     alert(data.message); // Hiển thị thông báo
        //                 } else {
        //                     alert(data.message); // Báo lỗi
        //                 }
        //             })
        //     });
        // });

        // nút chọn địa
        document.querySelectorAll('.select-address').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn trình duyệt reload

                const selectedId = this.getAttribute('data-id');

                // Đặt radio tương ứng được chọn
                document.getElementById(`address-${selectedId}`).checked = true;

                // Đổi giao diện nếu cần (ví dụ: highlight địa chỉ được chọn)
                document.querySelectorAll('.form-item').forEach(function(item) {
                    item.classList.remove('selected'); // Xóa trạng thái selected
                });
                this.closest('.form-item').classList.add('selected'); // Đánh dấu địa chỉ được chọn
            });
        });

        // nút thêm địa chỉ mới, khi click sẽ hiện nút cho khách điền địa chỉ mới
        document.getElementById('add-address').addEventListener('click', function(e) {
            e.preventDefault(); // Ngăn trình duyệt load lại trang
            document.getElementById('address-form').style.display = 'block'; // Hiển thị form
        });
    </script>

@endsection

@push('scriptStore')
@endpush
