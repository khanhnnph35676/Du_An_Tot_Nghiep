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
                                        <button class="btn btn-primary select-address me-2" type="button"
                                            data-id="{{ $item['id'] }}">Chọn</button>

                                        <!-- Nút xóa -->
                                        <button class="btn btn-danger delete-address" type="button"
                                            data-id="{{ $item['id'] }}">Xóa</button>
                                    </div>
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#add_address">Thêm địa chỉ mới</button>
                        @endif
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
                        <div class="form-item">
                            <label class="form-label my-3">Phương thức thanh toán<sup>*</sup></label>
                            <div class="payment-id">
                                @foreach ($payments as $payment)
                                    <input type="radio" name="payment_id" value="{{ $payment->id }}"
                                        id="payment-{{ $payment->id }}"  @if($payment->id == '1') checked @endif>
                                    <label class="form-label my-3 me-3">{{ $payment->name }}</label>
                                @endforeach
                            </div>
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
                                                @if ($product->id == $item['product_id'] && $product->type == 1 && Auth::id() == $item['user_id'])
                                                    <tr class="mt-1 mb-1">
                                                        <th scope="row">
                                                            <div class="d-flex align-items-center">
                                                                <img src=" {{ asset($product->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </div>
                                                        </th>
                                                        <td class="align-middle">
                                                            {{ $product->name }}
                                                        </td>
                                                        <td class="align-middle">
                                                            <input type="text" name='price' value="{{$product->price}}" hidden>
                                                            <p class="mb-0">{{ number_format($product->price) }} vnđ
                                                            </p>
                                                        </td>
                                                        <td class="text-center align-middle">{{$item['qty'] }}</td>
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
                                                            <td scope="row">
                                                                <img src="{{ asset($productVariant->image) }}"
                                                                    class="img-fluid me-5 rounded-circle"
                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                    alt="Ảnh sản phẩm">
                                                            </td>
                                                            <td class="align-middle">
                                                                {{ $product->name . ' - ' . $productVariant->sku }}
                                                            </td>
                                                            <td class="align-middle" style="width:100px;">
                                                                <p class="mb-0">
                                                                    {{ number_format($productVariant->price) }} vnđ
                                                                </p>
                                                                <input type="text" name='price'
                                                                    value="{{ $productVariant->price }}" hidden>
                                                            </td>
                                                            <td class="text-center align-middle">{{$item['qty'] }}</td>
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
                                        <td class="py-3">
                                            <p class="mb-0 text-dark py-4">Shipping</p>
                                        </td>
                                        <td colspan="3" class="py-3">
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
                                        <td class="py-3">
                                            <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                        </td>
                                        <td class="py-3"></td>
                                        <td class="py-3">
                                            <div class="border-bottom border-top">
                                                <p class="m-2 text-dark">{{ number_format($sumPrice + 15000) }} vnđ</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @php
                            print_r($cart);
                        @endphp
                        <div id="payment-button">
                            <!-- Mặc định hiển thị cho COD -->
                            <input type="text" name='sum_price' value="{{ $sumPrice + 15000 }}" hidden>
                            <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">
                                Thanh toán COD
                            </button>
                        </div>
                        <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" id='momoPayment'
                            style="display:none;">
                            Thanh toán qua ATM Momo
                        </button>
                        @error('payment_id')
                        <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                        </div>
                        @enderror
            </form>
        </div>
    </div>

    </div>
    </div>
    <!-- Checkout Page End -->
    <!-- Thêm địa chỉ -->
    <div class="modal fade" id="add_address" tabindex="-1" aria-labelledby="addAddressModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addAddressModel">Modal title</h1>
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
    <script>
        // Khai báo đối tượng lưu tên các tỉnh, quận, xã
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

                // Nếu tất cả địa chỉ bị xóa, có thể hiển thị thông báo
                const remainingAddresses = document.querySelectorAll('.address-item');
                if (remainingAddresses.length === 0) {
                    alert('Tất cả địa chỉ đã bị xóa!');
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
                            alert(data.message); // Hiển thị thông báo
                        } else {
                            alert(data.message); // Báo lỗi
                        }
                    })
            });
        });
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

        // phương thức thanh toán
        document.querySelectorAll('input[name="payment_id"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                const paymentButtonCOD = document.querySelector('#payment-button');
                const paymentButtonMoMo = document.querySelector('#momoPayment');

                if (this.value == 1) { // Hiển thị COD
                    paymentButtonCOD.style.display = 'block';
                    paymentButtonMoMo.style.display = 'none';
                } else if (this.value == 2) { // Hiển thị MoMo
                    paymentButtonCOD.style.display = 'none';
                    paymentButtonMoMo.style.display = 'block';
                }
            });
        });
    </script>

@endsection

@push('scriptStore')
@endpush





{{-- <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
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
</div> --}}
