@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/variant.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Xin chào, chào mừng trở lại!</h4>
                    <span class="ml-1">Quản lý Voucher</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Danh sách Voucher</h2>
                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-secondary">
                            <i class="fa fa-plus mr-1"></i>Thêm Voucher
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Giảm giá (%)</th>
                                    <th>Mã</th>
                                    <th>Số lượng</th>
                                    <th>Điểm</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->sale }}</td>
                                        <td>{{ $voucher->code_voucher }}</td>
                                        <td>{{ $voucher->qty }}</td>
                                        <td>{{ $voucher->point }}</td>
                                        <td>{{ $voucher->start_date }}</td>
                                        <td>{{ $voucher->end_date }}</td>
                                        <td>
                                            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-secondary btn-sm">Sửa</a>
                                            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-dark btn-sm">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Không có voucher nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
