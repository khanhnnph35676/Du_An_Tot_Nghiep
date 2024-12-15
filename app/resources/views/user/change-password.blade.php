@extends('user.layout.default')

@section('content')
    <style>

        .order-status-menu {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            cursor: pointer;
        }

        .status-title {
            font-weight: bold;
            border: none;
            font-size: 18px;
            padding: 5px 10px;
            border-radius: 0px;
            background-color: #fff;
            flex-grow: 1;
            text-align: center;
            margin: 5px
        }

        .status-title:hover {
            background-color: #daddd4c7;
        }

        .content-order {
            overflow: auto;
            max-height: 600px;
            /* background: #007bff; */
        }

        .content-order::-webkit-scrollbar {
            width: 3px;
            /* Độ rộng thanh cuộn */
        }

        .content-order::-webkit-scrollbar-thumb {
            background: #888;
            /* Màu của thanh cuộn */
            border-radius: 4px;
            /* Bo góc cho thanh cuộn */
        }

        .content-order::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Màu khi hover */
        }

        .order-details {
            display: none;
            display: grid;
            margin-top: 15px;
        }

        .order-item {
            padding: 10px;
            border: 1px solid #c0c1be;
            border-radius: 8px;
            background-color: #f9f9f9;
            width: calc(25% - 15px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;

        }

        .order-item .order-id {
            font-weight: bold;
            border-radius: 5%;
            padding: 5px;
            background-color: #fff;
            margin-top: 10px;
            border-radius: 8px;
        }

        .order-item img {
            max-width: 100%;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .view-details {
            text-decoration: none;
            color: #007bff;
        }

        .view-details:hover {
            text-decoration: underline;
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

        .order-items-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        #order-items {
            display: flex;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
        }

        .order-item {
            flex: 0 0 auto;
            scroll-snap-align: start;
            margin-right: 10px;
        }

        .order-items-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 10;
        }

        button {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }

        button:disabled {
            background: rgba(0, 0, 0, 0.2);
        }

        .huy:hover {
            background: rgba(249, 0, 0, 0.337);
            color: white;
        }

        .status-title {
            color: #333;
        }

        .danhgia:hover {
            background: rgba(5, 220, 5, 0.687)
        }
    </style>
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
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đổi mật khẩu</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('storeHome') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Đổi mật khẩu</li>
        </ol>
    </div>
    <div class="container mt-5">
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
                    <li class="p-2 mt-2"><a href="{{ route('user.change-password') }}" class="text-dark"><strong>Đổi mật khẩu</strong>
                        </a> </li>
                </ul>
            </div>
            <div class="col-lg-9">
                <form class="ahi" method="POST" action="{{ route('user.update-password') }}">
                    @csrf
                    <h2>Đổi Mật Khẩu</h2>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control w-60" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control w-60" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control w-60" id="new_password_confirmation"
                            name="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </form>
            </div>
        </div>

    </div>
@endsection
