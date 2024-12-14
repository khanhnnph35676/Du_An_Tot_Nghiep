@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************Content body start***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Quản lý điểm thưởng</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Quản lý điểm thưởng</a></li>
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
                            <h4 class="card-title">Quản lý điểm thưởng</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Tến người dùng</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Điểm thưởng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listPoints as $key => $value)
                                            <tr>
                                                <td>{{ $key +1 }} </td>

                                                <td>
                                                    @if ($value->users->avatar != null)
                                                        <img src="{{ asset('storage/' . $value->users->avatar) }}"class="rounded mr-2"
                                                            style="width: 42px; height: 42px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('storage/avatars/OIP.jpg') }}"
                                                            class="rounded mr-2"
                                                            style="width: 42px; height: 42px; object-fit: cover;">
                                                    @endif
                                                    {{ $value->users->name }}
                                                </td>
                                                <td>{{ $value->users->email }} </td>
                                                <td>{{ $value->users->phone }} </td>
                                                <td>{{ $value->point ?? '0'}} đ</td>
                                                <td><a href="{{ route('admin.updatePoint', ['id' => $value->id]) }}"
                                                        class="btn btn-secondary"> Cập nhật </a></td>

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
    <!--**********************************Content body end ***********************************-->


    <script></script>
@endsection

@push('scriptHome')
@endpush
