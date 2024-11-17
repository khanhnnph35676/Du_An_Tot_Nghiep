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
                    <h4>Chào mừng đến với quản lý Blog</h4>
                </div>
            </div>
        </div>

        @if (session('insert-message'))
            <div class="alert alert-success">
                <ul>
                    @if(session('insert-message'))
                        <li>{{ session('insert-message') }}</li>
                    @endif
                </ul>
            </div>
        @endif

        @if(session('delete-message'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{ session('delete-message') }}</li>
                </ul>
            </div>
        @endif  

        @if(session('update-message'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('update-message') }}</li>
                </ul>
            </div>
        @endif



        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Danh sách Blog</h4>
                        <div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addPostModal">Thêm Blog mới</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="data-tables table mb-0 tbl-server-info text-dark">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>ID Tin tức</th>
                                <th>Tiêu đề</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Ẩn/Hiện</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody class="ligth-body">
                            @foreach($list_blog as $key => $blog)
                            <tr>
                                <td>{{$blog->idBlog}}</td>
                                <td>
                                    <img src="{{asset('/storage/images/blog/'.$blog->BlogImage)}}" class="img-fluid rounded avatar-50 mr-3" alt="image">
                                    {{$blog->BlogTitle}}
                                </td>
                                <td>{{$blog->created_at}}</td>
                                <td>{{$blog->updated_at}}</td>
                                <td>
                                    @if($blog->Status == 0) Ẩn
                                    @else Hiện 
                                    @endif
                                </td>
                                <td>
                                    <!-- Nút chi tiết -->
                                    <a href="{{ route('admin.blog.blog_details', ['BlogSlug' => $blog->BlogSlug]) }}" class="btn btn-info">Xem chi tiết</a>
                                    <!-- Nút Xóa -->
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $blog->idBlog }}">Xóa</button>
                                    <!-- Nút Cập nhật -->
                                    {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#updatePostModal{{ $blog->idBlog }}">Cập nhật</button> --}}
                                    <a href="{{ route('admin.blog.edit_blog', $blog->idBlog) }}" class="btn btn-warning">Cập nhật</a>

                                </td>
                            </tr>

                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" id="modal-delete-{{$blog->idBlog}}"  aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thông báo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có muốn xóa bài viết #{{$blog->idBlog}} không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Trở về</button>
                                            <a href="{{URL::to('/delete-blog/'.$blog->idBlog)}}" type="button" class="btn btn-primary">Xác nhận</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding New Post -->
    <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Thêm Blog mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Thêm tin tức</h4>
                        </div>
                    </div>
                    <div class="card-body">
                     <form method="post" action="{{URL::to('admin/submit-add-blog')}}" id="form-add-blog" data-toggle="validator" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Tiêu đề -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tiêu đề *</label>
                                    <input type="text" name="BlogTitle" class="form-control slug" onkeyup="ChangeToSlug()" placeholder="Nhập tiêu đề tin tức" value="{{ old('BlogTitle') }}" >
                                    @error('BlogTitle')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Slug -->
                            <input type="hidden" name="BlogSlug" class="form-control" id="convert_slug" value="{{ old('BlogSlug') }}">

                            <!-- Ảnh tin tức -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Ảnh tin tức *</label>
                                    <input type="file" name="BlogImage" id="images" onchange="loadPreview(this)" class="form-control image-file" >
                                    @error('BlogImage')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mô tả ngắn -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Mô tả ngắn *</label>
                                    <textarea class="form-control" name="BlogDesc" id="BlogDesc">{{ old('BlogDesc') }}</textarea>
                                    <script>$(document).ready(function(){CKEDITOR.replace('BlogDesc');});</script>
                                    @error('BlogDesc')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nội dung -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nội dung *</label>
                                    <textarea class="form-control" name="BlogContent">{{ old('BlogContent') }}</textarea>
                                    <script>$(document).ready(function(){CKEDITOR.replace('BlogContent');});</script>
                                    @error('BlogContent')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Ẩn/Hiện *</label>
                                    <select class="selectpicker form-control" data-style="py-0" name="Status" >
                                        <option value="">Chọn trạng thái hiển thị</option>
                                        <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Ẩn</option>
                                        <option value="1" {{ old('Status') == '1' ? 'selected' : '' }}>Hiện</option>
                                    </select>
                                    @error('Status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mr-2" id="btn-submit" value="Thêm tin tức">
                    </form>

                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- Modal Xóa Blog -->
    @foreach ($list_blog as $blog)
        <div class="modal fade" id="deleteModal{{ $blog->idBlog }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $blog->idBlog }}" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $blog->idBlog }}">Xóa Blog: {{ $blog->BlogTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-dark">
                        <p>Bạn có chắc chắn muốn xóa bài blog "<strong>{{ $blog->BlogTitle }}</strong>"?</p>
                        <p>Hành động này sẽ không thể hoàn tác.</p>
                    </div>
                    <div class="modal-footer">
                        <!-- Form Xóa -->
                        <form action="{{ route('admin.blog.delete', $blog->idBlog) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach  
    
                
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
