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
                        <h4>Hi, welcome back!</h4>
                        <p class="mb-0">Your business dashboard template</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile">
                        <div class="profile-head">
                            <div class="photo-content">
                                <div class="cover-photo"></div>
                                <div class="profile-photo">
                                    <img src="images/profile/profile.png" class="img-fluid rounded-circle" alt="">
                                </div>
                            </div>
                            <div class="profile-info">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-4 border-right-1 prf-col">
                                                <div class="profile-name">
                                                    <h4 class="text-primary">{{ auth()->user()->name }}</h4>
                                                    <p>UX / UI Designer</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-4 border-right-1 prf-col">

                                                <div class="profile-email">
                                                    <h4 class="text-muted">{{ auth()->user()->email }}</h4>
                                                    <p>Email</p>
                                                </div>
                                            </div>
                                            <!-- <div class="col-xl-4 col-sm-4 prf-col">
                                                <div class="profile-call">
                                                    <h4 class="text-muted">(+1) 321-837-1030</h4>
                                                    <p>Phone No.</p>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-statistics">
                                <div class="text-center mt-4 border-bottom-1 pb-3">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="m-b-0">150</h3><span>Follower</span>
                                        </div>
                                        <div class="col">
                                            <h3 class="m-b-0">140</h3><span>Place Stay</span>
                                        </div>
                                        <div class="col">
                                            <h3 class="m-b-0">45</h3><span>Reviews</span>
                                        </div>
                                    </div>
                                    <div class="mt-4"><a href="javascript:void()"
                                            class="btn btn-primary pl-5 pr-5 mr-3 mb-4">Follow</a> <a
                                            href="javascript:void()" class="btn btn-dark pl-5 pr-5 mb-4">Send
                                            Message</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#about-me" data-toggle="tab"
                                                class="nav-link active show ">About Me</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="about-me" class="tab-pane fade active show">
                                            <div class="profile-about-me">
                                                <div class="pt-4 border-bottom-1 pb-4">
                                                    <h4 class="text-primary">Personal Information</h4>
                                                </div>
                                            </div>
                                            <div class="profile-personal-info">
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span>{{ auth()->user()->name }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span>{{ auth()->user()->email }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Phone <span class="pull-right">:</span></h5>
                                                    </div>
                                                    <div class="col-9"><span>{{ auth()->user()->phone }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Gender <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span>{{ auth()->user()->gender }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Birthday <span class="pull-right">:</span></h5>
                                                    </div>
                                                    <div class="col-9"><span>{{ auth()->user()->birth_date }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
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
    <script src="{{ asset('backend/js/product.js') }}"></script>

    <script>
        // Preview hình ảnh avatar
        function previewImage(event) {
            var imagePreview = document.getElementById('imagePreview');
            var removeImage = document.getElementById('removeImage');
            var reader = new FileReader();
            reader.onload = function() {
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
                removeImage.style.display = 'inline';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Xóa hình ảnh
        document.getElementById('removeImage').addEventListener('click', function() {
            document.getElementById('imageUpload').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('removeImage').style.display = 'none';
        });
    </script>
@endsection

@push('scriptHome')
@endpush
