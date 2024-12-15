@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/variant.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Xin chào, chào mừng trở lại!</h4>
                    <span class="ml-1">Thêm Voucher</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Thêm Voucher Mới</h2>
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-dark">
                            <i class="fa fa-arrow-left mr-1"></i>Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.vouchers.store') }}" method="POST">
                            @csrf
                            @include('admin.vouchers.form')
                            <button type="submit" class="btn btn-secondary mb-3">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
