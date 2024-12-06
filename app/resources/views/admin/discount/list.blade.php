@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************
                    Content body start
                ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Danh sách mã giảm giá</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Danh sách mã giảm giá</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            @if (session('message'))
                <div class="message">
                    <div class="alert alert-primary alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                    class="mdi mdi-close"></i></span>
                        </button>
                        @if (session('message'))
                            <strong>{{ session('message') }}</strong>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách mã giảm giá</h4>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.createDiscount') }}" class="btn btn-secondary">Thêm mã</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Mã giảm giá</th>
                                            <th>Giảm</th>
                                            <th>Độ ưu tiên</th>
                                            <th>Số lượng</th>
                                            <th>Thời gian bắt đầu</th>
                                            <th>Thời gian kết thúc</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($discounts as $discount)
                                            <tr>
                                                <td>{{ $discount->id }}</td>
                                                <td> {{ $discount->name }}</td>
                                                <td>{{ $discount->discount }} %</td>
                                                <td>{{ $discount->priority }}</td>
                                                <td>{{ $discount->qty }}</td>
                                                <td>{{ $discount->start_date }}</td>
                                                <td>{{ $discount->end_date }}</td>
                                                <td>
                                                    <a href="{{ route('admin.updateDiscount', $discount->id) }}"
                                                        class="btn btn-secondary">Sửa</a>
                                                    <form action="{{ route('admin.discount.destroy', $discount->id) }}"
                                                        method="POST" style="display: inline-block;"> @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-dark"
                                                            onclick="return confirm('Bạn có muốn xóa {{ $discount->name }} (Mã: {{ $discount->id }}) không???')">Xoá</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
                    Content body end
                ***********************************-->
@endsection

@push('scriptHome')
@endpush
