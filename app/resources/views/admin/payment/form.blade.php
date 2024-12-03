
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
                            <span class="ml-1">Phương thức thanh toán</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trang chủ</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Phương thức thanh toán</a></li>
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
                                <h4 class="card-title">Phương thức thanh toán</h4>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.createPayment')}}" class="btn btn-secondary">Thêm mới</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Tên phương thức</th>
                                                <th>Ảnh</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ $payment->name }}</td>
                                                <td><img src="{{ Storage::url($payment->image) }}"
                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                    alt=""></td>
                                                <td>
                                                    <a href="{{ route('admin.updatePayment', $payment->id)}}" class="btn btn-primary">Sửa</a>
                                                    <form action="{{ route('admin.payment.destroy', $payment->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-dark"
                                                            onclick="returnconfirm('Bạn có muốn xóa {{$payment->name}} (Mã: {{$payment->id}}) không???')">
                                                            Xoá
                                                        </button>
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



