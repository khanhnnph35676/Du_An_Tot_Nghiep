@extends('admin.layout.default')

@push('styleHome')
    <!-- Datatable -->
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Danh sách người dùng</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                    </ol>
                </div>
            </div>
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
                            <h4 class="card-title">Danh sách người dùng</h4>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.customerCreate') }}" class="btn btn-secondary">Thêm tài khoản</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Giới tính</th>
                                            <th>Ngày sinh</th>
                                            {{-- <th>Chức vụ</th> --}}
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td class="text-center">{{ $user->id }}</td>
                                                <td>
                                                    @if ($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                                        alt="{{ $user->name }}"  class="rounded mr-2"
                                                        style="width: 42px; height: 42px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('storage/avatars/OIP.jpg') }}" class="rounded mr-2"
                                                    style="width: 42px; height: 42px; object-fit: cover;" alt="">
                                                @endif
                                                    {{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone?$user->phone: 'Không có'}}</td>
                                                <td>
                                                    {{ $user->gender == 'male'?"Nam":''}}
                                                    {{ $user->gender == 'female'?"Nữ":''}}
                                                </td>
                                                <td>
                                                    {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') : 'N/A' }}
                                                </td>
                                                {{-- <td>
                                                    <span class="badge badge-info">{{ optional($user->rule)->rule_name }}</span>
                                                        {{-- @if (optional($user->rule)->id === 2)

                                                        @else
                                                            <span class="badge badge-secondary">{{ optional($user->rule)->rule_name }}</span>
                                                        @endif --}}
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.customerEdit', $user->id) }}"
                                                            class="btn btn-secondary mr-1">Sửa</a>
                                                        <form action="{{ route('admin.customerDestroy', $user->id) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-dark">Xoá</button>
                                                        </form>
                                                    </div>
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

    <script src="{{ asset('backend/js/product.js') }}"></script>
@endsection


@push('scriptHome')
@endpush
