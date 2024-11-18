@extends('admin.layout.default')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
    <style>
        .cke_notification { 
            display: none !important; 
        }
    </style>

 <link rel="stylesheet" href="{{ asset('backend/css/blog.css') }}">



<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Chỉnh sửa Blog</h4>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="empty-cart-page section-padding-5">
                        {{-- <div class="container"> --}}
                            <div class="content-page">
                                <div class="container-fluid add-form-list">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                </div>
                                                <div class="card-body">
                                                    {{-- <form  method="post" action="{{URL::to('/submit-edit-blog/'.$blog->idBlog)}}" id="form-add-blog" data-toggle="validator" enctype="multipart/form-data"> --}}
                                                    <form  method="post" action="{{ route('admin.blog.submit-edit-blog', $blog->idBlog) }}" id="form-add-blog" data-toggle="validator" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row"> 
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Tiêu đề *</label>
                                                                    <input type="text" name="BlogTitle" value="{{$blog->BlogTitle}}" class="form-control slug" onkeyup="ChangeToSlug()" placeholder="Nhập tiêu đề tin tức" required>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="BlogSlug" value="{{$blog->BlogSlug}}" class="form-control" id="convert_slug">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Ảnh tin tức *</label>
                                                                    <input type="file" name="BlogImage" id="images" onchange="loadPreview(this)" class="form-control image-file">
                                                                    <div class="text-danger alert-img"></div>
                                                                    <div class="d-flex flex-wrap" id="image-list">
                                                                        <div id="image-item-0" class="image-item">
                                                                            <img src="{{asset('/storage/images/blog/'.$blog->BlogImage)}}" class="img-fluid rounded avatar-100 mr-3 mt-2">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Mô tả ngắn *</label>
                                                                    <textarea class="form-control" name="BlogDesc">{{$blog->BlogDesc}}</textarea>
                                                                    <script>$(document).ready(function(){CKEDITOR.replace('BlogDesc');});</script>
                                                                    <div class="text-danger alert-desblog"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Nội dung *</label>
                                                                    <textarea class="form-control" name="BlogContent">{{$blog->BlogContent}}</textarea>
                                                                    <script>$(document).ready(function(){CKEDITOR.replace('BlogContent');});</script>
                                                                    <div class="text-danger alert-contentblog"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Ẩn/Hiện *</label>
                                                                    <select class="selectpicker form-control" data-style="py-0" name="Status">
                                                                        <option value="{{$blog->Status}}">
                                                                            @if($blog->BlogStatus == 0) Ẩn
                                                                            @else Hiện
                                                                            @endif
                                                                        </option>
                                                                        <option value="0">Ẩn</option>
                                                                        <option value="1">Hiện</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="submit" class="btn btn-primary mr-2" id="btn-submit" value="Sửa tin tức">
                                                        {{-- <a href="{{URL::to('/manage-blog')}}" class="btn btn-light mr-2">Trở Về</a> --}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    
                
</div>

<script src="{{ asset('backend/js/blog.js') }}"></script>
<script>
    function ChangeToSlug() {
    var title = document.querySelector('.slug').value;
    var slug = title.toLowerCase();

    // Loại bỏ ký tự đặc biệt
    slug = slug.replace(/[^a-zA-Z0-9\s-]/g, '');

    // Thay khoảng trắng bằng dấu gạch ngang
    slug = slug.replace(/\s+/g, '-');

    // Xóa dấu gạch ngang dư thừa
    slug = slug.replace(/^-+|-+$/g, '');

    // Gán slug vào ô input ẩn
    document.getElementById('convert_slug').value = slug;
}

</script>


@endsection
