@extends('admin.layout.default')

@push('styleHome')
    <!-- Datatable -->
@endpush

@section('content')
    <style>
        .list-group-item {
            cursor: pointer;
        }

        .list-group-item:hover {
            background: #d1cece35;
        }

        .wrapper-img{
            position: relative;
        }
        .success {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #00ff44;
            border: 1px solid #fff;
        }

        .wrapper-img, .wrapper-img img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .sroll::-webkit-scrollbar {
            width: 1px;
            /* Độ rộng thanh cuộn */
        }

        .sroll::-webkit-scrollbar-thumb {
            background: #d3d0d0;
            /* Màu của thanh cuộn */
            border-radius: 1px;
            /* Bo góc cho thanh cuộn */
        }

        .sroll::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Màu khi hover */
        }

    </style>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Kênh trò chuyện</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Kênh trò chuyện</a></li>
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
                            <h4 class="card-title">Kênh trò chuyện</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Danh sách người dùng -->
                                <div class="col-4 border m-0 p-1">
                                    <ul class="list-group sroll" style="height: 500px; overflow-y: auto;">
                                        @foreach ($users as $user)
                                            <li class="list-group-item d-flex align-items-center">
                                                <div class="wrapper-img mr-3">
                                                    @if ($user->avatar)
                                                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="">
                                                    @else
                                                        <img src="{{ asset('storage/avatars/OIP.jpg') }}" alt="">
                                                    @endif
                                                    <span class="success"></span>
                                                </div>
                                                <span>{{$user->name}} </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Nội dung trò chuyện -->
                                <div class="col-8">
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="wrapper-img mr-3">
                                            <img src="" alt="">
                                            <span class="success"></span>
                                        </div>
                                        <span>Khánh như ngueyenx</span>
                                    </div>
                                    <div class="chat-box p-3 border rounded sroll" style="height: 500px; overflow-y: auto;">
                                        <div class="d-flex justify-content-start ">
                                            <div class="wrapper-img mr-3">
                                                <img src="" alt="">
                                                <span class="success"></span>
                                            </div>
                                            <div class="message">
                                                <p class="border rounded pl-2 pr-2" >Chào bạn! Bạn có khỏe không?</p>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-end">
                                            <div class="message">
                                                <p class="bg-primary text-white border rounded pl-2 pr-2" >Vâng, mình ổn. Cảm ơn bạn!</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start ">
                                            <div class="wrapper-img mr-3">
                                                <img src="" alt="">
                                                <span class="success"></span>
                                            </div>
                                            <div class="message">
                                                <p class="border rounded pl-2 pr-2" >Theo Next Apple, con trai của nữ sĩ - ông Trần Trung Duy -
                                                    và vợ con làm theo di nguyện của nhà văn, không tổ chức lễ viếng công khai,</p>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-start">
                                            <div class="message">
                                                <p class="bg-primary text-white rounded border pl-2 pr-l" >Theo Next Apple, con trai của nữ sĩ - ông Trần Trung Duy -
                                                    và vợ con làm theo di nguyện của nhà văn, không tổ chức lễ viếng công khai,
                                                    chỉ thực hiện nghi lễ riêng tư. Diễn viên Lâm Tâm Như - người thân thiết với gia đình nhà văn - đến dự.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ô nhập nội dung -->
                                    <form class="mt-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Nhập nội dung...">
                                            <button class="btn btn-primary" type="submit">Gửi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scriptHome')
@endpush
