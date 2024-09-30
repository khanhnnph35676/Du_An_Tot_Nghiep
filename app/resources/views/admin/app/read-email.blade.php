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
                            <h4>Hi, welcome back!</h4>
                            <span class="ml-1">Email</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Email</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Read</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="email-left-box generic-width px-0 mb-5">
                                    <div class="p-0">
                                        <a href="email-compose.html" class="btn btn-primary btn-block">Compose</a>
                                    </div>
                                    <div class="mail-list mt-4">
                                        <a href="email-inbox.html" class="list-group-item active"><i
                                                class="fa fa-inbox font-18 align-middle mr-2"></i> Inbox <span
                                                class="badge badge-primary badge-sm float-right">198</span> </a>
                                        <a href="javascript:void()" class="list-group-item"><i
                                                class="fa fa-paper-plane font-18 align-middle mr-2"></i>Sent</a> <a href="javascript:void()" class="list-group-item"><i
                                                class="fa fa-star font-18 align-middle mr-2"></i>Important <span
                                                class="badge badge-danger badge-sm text-white float-right">47</span>
                                        </a>
                                        <a href="javascript:void()" class="list-group-item"><i
                                                class="mdi mdi-file-document-box font-18 align-middle mr-2"></i>Draft</a><a href="javascript:void()" class="list-group-item"><i
                                                class="fa fa-trash font-18 align-middle mr-2"></i>Trash</a>
                                    </div>
                                    <div class="intro-title d-flex justify-content-between">
                                        <h5>Categories</h5>
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </div>
                                    <div class="mail-list mt-4">
                                        <a href="email-inbox.html" class="list-group-item"><span class="icon-warning"><i
                                                    class="fa fa-circle" aria-hidden="true"></i></span>
                                            Work </a>
                                        <a href="email-inbox.html" class="list-group-item"><span class="icon-primary"><i
                                                    class="fa fa-circle" aria-hidden="true"></i></span>
                                            Private </a>
                                        <a href="email-inbox.html" class="list-group-item"><span class="icon-success"><i
                                                    class="fa fa-circle" aria-hidden="true"></i></span>
                                            Support </a>
                                        <a href="email-inbox.html" class="list-group-item"><span class="icon-dpink"><i
                                                    class="fa fa-circle" aria-hidden="true"></i></span>
                                            Social </a>
                                    </div>
                                </div>
                                <div class="email-right-box ml-0 ml-sm-4 ml-sm-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="right-box-padding">
                                                <div class="toolbar" role="toolbar">
                                                    <div class="btn-group mb-4">
                                                        <button type="button" class="btn btn-dark"><i
                                                                class="fa fa-archive"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-dark"><i
                                                                class="fa fa-exclamation-circle"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-dark"><i
                                                                class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group mb-4">
                                                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"><i class="fa fa-folder"></i> <b
                                                                class="caret m-l-5"></b>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group mb-4">
                                                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tag"></i> <b
                                                                class="caret m-l-5"></b>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group mb-4">
                                                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown">More <span
                                                                class="caret m-l-5"></span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript: void(0);">Mark as
                                                                Unread</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Add to
                                                                Tasks</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Add
                                                                Star</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="read-content">
                                                    <div class="media pt-3">
                                                        <img class="mr-4 rounded-circle" alt="image" src="./images/avatar/1.jpg">
                                                        <div class="media-body">
                                                            <h5 class="text-primary">Ingredia Nutrisha</h5>
                                                            <p class="mb-0">20 May 2018</p>
                                                        </div>
                                                        <a href="javascript:void()" class="text-muted "><i
                                                                class="fa fa-reply"></i> </a>
                                                        <a href="javascript:void()" class="text-muted ml-3"><i
                                                                class="fa fa-long-arrow-right"></i> </a>
                                                        <a href="javascript:void()" class="text-muted ml-3"><i
                                                                class="fa fa-trash"></i></a>
                                                    </div>
                                                    <hr>
                                                    <div class="media mb-4 mt-5">
                                                        <div class="media-body"><span class="pull-right">07:23 AM</span>
                                                            <h5 class="my-1 text-primary">A collection of textile samples lay spread</h5>
                                                            <p class="read-content-email">
                                                                To:Me,invernessmckenzie@example.com</p>
                                                        </div>
                                                    </div>
                                                    <div class="read-content-body">
                                                        <h5 class="mb-5">Hi,Ingredia,</h5>
                                                        <p><strong>Ingredia Nutrisha,</strong> A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture</p>
                                                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for
                                                            the far World of Grammar. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                                                        </p>
                                                        <p>Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut
                                                            metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum
                                                            rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar,</p>
                                                        <h5 class="pt-3">Kind Regards</h5>
                                                        <p>Mr Smith</p>
                                                        <hr>
                                                    </div>
                                                    <div class="read-content-attachment">
                                                        <h6><i class="fa fa-download mb-2"></i> Attachments
                                                            <span>(3)</span></h6>
                                                        <div class="row attachment">
                                                            <div class="col-auto">
                                                                <a href="javascript:void()" class="text-muted">My-Photo.png</a>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="javascript:void()" class="text-muted">My-File.docx</a>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="javascript:void()" class="text-muted">My-Resume.pdf</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group pt-3">
                                                        <textarea class="w-100" name="write-email" id="write-email" cols="30" rows="5" placeholder="It's really an amazing.I want to know more about it..!"></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button class="btn btn-primary btn-sl-sm mb-5" type="button">Send</button>
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
        <!-- Required vendors -->
    <script src=" {{ asset('focus-2/focus-2/vendor/global/global.min.js') }} "></script>
    <script src=" {{ asset('focus-2/focus-2/js/quixnav-init.js') }} "></script>
    <script src=" {{ asset('js/custom.min.js') }} "></script>
    <!--removeIf(production)-->
    <!-- Demo scripts -->
@endsection

@push('scriptHome')

@endpush


