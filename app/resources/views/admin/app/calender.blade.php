@extends('admin.layout.default')
@push('styleHome')
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
                        <h4>Chào bạn, chào mừng quay trở lại!</h4>
                        <p class="mb-0">Mẫu bảng điều khiển doanh nghiệp của bạn</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Ứng dụng</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Lịch</a></li>
                    </ol>
                </div>
            </div>
            <!-- dòng -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-intro-title">Lịch</h4>

                            <div class="">
                                <div id="external-events" class="my-3">
                                    <p>Kéo và thả sự kiện của bạn hoặc nhấp vào lịch</p>
                                    <div class="external-event" data-class="bg-primary"><i class="fa fa-move"></i>Phát hành
                                        giao diện mới</div>
                                    <div class="external-event" data-class="bg-success"><i class="fa fa-move"></i>Sự kiện
                                        của tôi
                                    </div>
                                    <div class="external-event" data-class="bg-warning"><i class="fa fa-move"></i>Họp quản
                                        lý</div>
                                    <div class="external-event" data-class="bg-dark"><i class="fa fa-move"></i>Tạo giao diện
                                        mới</div>
                                </div>
                                <!-- ô checkbox -->
                                <div class="checkbox checkbox-event pt-3 pb-5">
                                    <input id="drop-remove" class="styled-checkbox" type="checkbox">
                                    <label class="ml-2 mb-0" for="drop-remove">Xóa sau khi thả</label>
                                </div>
                                <a href="javascript:void()" data-toggle="modal" data-target="#add-category"
                                    class="btn btn-primary btn-event w-100">
                                    <span class="align-middle"><i class="ti-plus"></i></span> Tạo mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body" style="z-index: 0;">
                            <div id="calendar" class="app-fullcalendar"></div>
                        </div>
                    </div>
                </div>
                <!-- BẮT ĐẦU MODAL -->
                <div class="modal fade none-border" id="event-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Thêm sự kiện mới</strong></h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark waves-effect border"
                                    data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-secondary save-event waves-effect waves-light">Tạo sự
                                    kiện</button>

                                <button type="button" class="btn btn-secondary delete-event waves-effect waves-light"
                                    data-dismiss="modal">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Thêm danh mục -->
                <div class="modal fade none-border" id="add-category">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Thêm danh mục</strong></h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Tên danh mục</label>
                                            <input class="form-control form-white" placeholder="Nhập tên" type="text"
                                                name="category-name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Chọn màu danh mục</label>
                                            <select class="form-control form-white" data-placeholder="Chọn một màu..."
                                                name="category-color">
                                                <option value="success">Thành công</option>
                                                <option value="danger">Nguy hiểm</option>
                                                <option value="info">Thông tin</option>
                                                <option value="pink">Hồng</option>
                                                <option value="primary">Chính</option>
                                                <option value="warning">Cảnh báo</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-secondary waves-effect waves-light save-category"
                                    data-dismiss="modal">Lưu</button>
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
    <!-- Required vendors -->
@endsection

@push('scriptHome')
@endpush
