<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Web Fonts -->

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h1,
        h2 {
            color: #333;
        }

        h4 {
            color: #333;
            text-align: center;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: middle;
        }

        .table th {
            background-color: #f1f1f1;
            color: #333;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table img {
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .border {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mt-5,
        .mb-5 {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        /* CSS cho nút */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-color: #007bff42;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            /* Xóa gạch chân */
            transition: background-color 0.3s ease;
        }

        a {
            color: white;
        }

        /* Thêm hiệu ứng hover */
        .btn:hover {
            background-color: #0057b377;
        }
    </style>
</head>

<body>
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 style='color:rgba(129, 196, 8, 1);'>J-snack</h1>
            <h1>Xin chào </h1>
            <h3>{{ $userSearch->email }} !</h3>
            <h2 class="mb-4 text-center">Chúc mừng bạn đã đặt hàng thành công tài cửa hàng bán đò ăn vặt J-Snack .</h2>
            <h2>Dưới đây là thông tin đơn hàng của bạn</h2>
            <div class="row g-4">
                <div class="col-lg-12 border">
                    <h4 class="mb-5 mt-5 text-center">Thông tin người đặt</h4>
                    <table class="table">
                        <tr>
                            <th style="width:20%;">Họ tên: </th>
                            <td class="text-start"> {{ $userSearch->name }}</td>
                        </tr>
                        <tr>
                            <th style="width:20%;">Email: </th>
                            <td class="text-start">{{ $userSearch->email }}</td>
                        </tr>
                        <tr>
                            <th style="width:20%;">Số điện thoại: </th>
                            <td class="text-start">{{ $userSearch->phone }}</td>
                        </tr>
                        <tr>
                            <th style="width:20%;">Địa chỉ: </th>
                            <td class="text-start">
                                {{ $orders->address->home_address . ', ' . $orders->address->address }}
                            </td>
                        </tr>
                    </table>
                    <h4 class="mb-5 mt-5 text-center">Thông tin đơn hàng</h4>
                    <table class="table">
                        <tr>
                            <th style="width:20%;">Mã đơn hàng: </th>
                            <td class="text-start"> {{ $orders->order_code }}</td>
                        </tr>
                        <tr>
                            <th style="width:20%;">Trạng thái: </th>
                            <td class="text-start"> {{ $orders->status == 0 ? 'Chưa xác nhận':'' }}</td>
                        </tr>
                        <tr>
                            <th style="width:20%;">Tình trạng thanh toán: </th>
                            <td class="text-start"> {{ $orders->check_payment_id == 0 ? 'Chưa thanh toán':'Đã thanh toán'}}</td>
                        </tr>
                        <tr>
                            <th style="width:20%;">Phương thức thanh toán: </th>
                            <td class="text-start"> {{ $orders->payments->name }}</td>
                        </tr>

                    </table>
                    <h4 class="mb-5 mt-5 text-center">Sản phẩm đã đặt</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productOrders as $key => $item)
                                @if ($item->product_variant_id == null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{-- <img src="{{ asset($item->products->image) }}"
                                                style="width: 60px; height: 60px; object-fit: cover;"> --}}

                                            <span>{{ $item->products->name }}</span>
                                        </td>
                                        <td>{{ number_format($item->price) }} Vnđ</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{-- <img src="{{ asset($item->product_variants->image)  }}"
                                                style="width: 60px; height: 60px; object-fit: cover;"> --}}
                                            <span>{{ $item->products->name . ' - ' . $item->product_variants->sku }}</span>
                                        </td>
                                        <td>{{ number_format($item->price) }} Vnđ</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th style="width:20%;">Phí vận chuyển: </th>
                                <td></td>
                                <td class="text-start"> 15.000 Vnđ</td>
                            </tr>
                            <tr>
                                <th style="width:20%;">Tính tiền: </th>
                                <td></td>
                                <td class="text-start"> {{ number_format($orders->sum_price) }} Vnđ</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($orderList->check_user == 0)
                        <h4 class="mb-5 mt-5 text-center">Do bạn chưa có mật khẩu nên chúng tôi đã tạo cho bạn tài khoản
                        </h4>
                        <table class="table">
                            <tr>
                                <th style="width:20%;">Tài khoản: </th>
                                <td class="text-start">{{ $userSearch->email }}</td>
                            </tr>
                            <tr>
                                <th style="width:20%;">Mật khẩu: </th>
                                <td class="text-start">abc123 </td>
                            </tr>
                        </table>
                        <a href="" style="color: #333">Cập nhật tài khoản</a>
                    @endif
                    <a href="{{ route('order.detail',['order_id' =>$orders->id]) }}" class="btn"> Xem đơn hàng </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
