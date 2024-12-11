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
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Danh sách bài viết</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Danh sách bài viết</a></li>
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
            <div class="row ">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Danh sách bài viết</h4>
                            <div>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addPostModal">Thêm
                                    mới</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="data-tables table mb-0 tbl-server-info text-dark">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tiêu đề</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th>Trạng thái</th>
                                        <th>Danh mục</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>

                                <tbody class="ligth-body">
                                    @foreach ($list_blog as $key => $blog)
                                        <tr>
                                            <td>{{ $blog->idBlog }}</td>
                                            <td>
                                                @if ($blog->BlogImage != null)
                                                    <img src="{{ asset('/storage/images/blog/' . $blog->BlogImage) }}"
                                                        alt=""
                                                        style="width: 100px; height: 60px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('/storage/images/blog/default.png') }}"
                                                        alt=""
                                                        style="width: 100px; height: 60px; object-fit: cover;">
                                                @endif
                                                <span class="ml-3">{{ $blog->BlogTitle }}</span>
                                            </td>
                                            <td>{{ $blog->created_at }}</td>

                                            <td>{{ $blog->updated_at }}</td>
                                            <td>{{ $blog->Status == 0 ? 'Ẩn' : 'Hiện' }}</td>
                                            <td> {{ $blog->blog_category_id != null ? $blog->blog_categories->blog_categories_name : 'N/A' }}
                                            </td>
                                            <td>
                                                <!-- Nút chi tiết -->
                                                {{-- <a href="{{ route('admin.blog.blog_details', ['BlogSlug' => $blog->BlogSlug]) }}"
                                                    class="btn btn-dark">Chi tiết</a> --}}
                                                <!-- Nút Cập nhật -->
                                                <a href="{{ route('admin.blog.edit_blog', $blog->idBlog) }}"
                                                    class="btn btn-secondary">Cập nhật</a>
                                                <!-- Nút Xóa -->
                                                <button class="btn btn-dark" data-toggle="modal"
                                                    data-id="{{ $blog->idBlog }}" data-target="#deleteBlog">Xóa</button>
                                                <!-- Button trigger modal -->
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteBlog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Thông báo</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="POST" id="formDelete">
                                                                @method('DELETE')
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Bạn có muốn xoá bài viết không?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-dark"
                                                                        data-dismiss="modal">Đóng</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Xoá</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
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
    <!-- Modal for Adding New Post -->
    <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel"
        aria-hidden="true">
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
                        <form method="post" action="{{ route('admin.submit_add_blog') }}" id="form-add-blog"
                            data-toggle="validator" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Tiêu đề -->
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Tiêu đề *</label>
                                        <input type="text" name="BlogTitle" class="form-control slug"
                                            onkeyup="ChangeToSlug()" placeholder="Nhập tiêu đề tin tức"
                                            value="{{ old('BlogTitle') }}">
                                        @error('BlogTitle')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="BlogSlug" class="form-control" id="convert_slug"
                                        value="{{ old('BlogSlug') }}">

                                    <!-- Ảnh tin tức -->
                                    <div class="form-group">
                                        <label>Ảnh tin tức *</label>
                                        <input type="file" name="BlogImage" id="images"
                                            onchange="loadPreview(this)" class="form-control image-file">
                                    </div>
                                    <!-- Mô tả ngắn -->
                                    <div class="form-group">
                                        <label>Mô tả ngắn *</label>
                                        <textarea class="form-control" name="BlogDesc" id="BlogDesc"></textarea>
                                        <script>
                                            $(document).ready(function() {
                                                CKEDITOR.replace('BlogDesc');
                                            });
                                        </script>
                                    </div>
                                    <!-- Nội dung -->
                                    <div class="form-group">
                                        <label>Nội dung *</label>
                                        <textarea class="form-control" name="BlogContent"></textarea>
                                        <script>
                                            $(document).ready(function() {
                                                CKEDITOR.replace('BlogContent');
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Trạng thái -->
                                    <div class="form-group">
                                        <label>Ẩn/Hiện *</label>
                                        <select class="selectpicker form-control" data-style="py-0" name="Status">
                                            <option value="">Chọn trạng thái hiển thị</option>
                                            <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Ẩn
                                            </option>
                                            <option value="1" {{ old('Status') == '1' ? 'selected' : '' }}>Hiện
                                            </option>
                                        </select>
                                    </div>
                                    {{-- danh mục bài viết --}}
                                    <div class="form-group">
                                        <label>Danh mục *</label>
                                        <select class="selectpicker form-control" data-style="py-0"
                                            name="blog_category_id">
                                            @foreach ($blog_categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $blog->blog_category_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->blog_categories_name }}</option>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary mr-2" id="btn-submit"
                                        value="Thêm tin tức">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('focus-2/focus-2/documentation/main/assets/js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/blog.js') }}"></script>
    <script>
        $('#deleteBlog').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút kích hoạt modal
            var id = button.data('id'); // Lấy giá trị từ thuộc tính data-id
            var modal = $(this); // Khai báo modal
            var formDelete = modal.find('#formDelete'); // Tìm form bên trong modal
            formDelete.attr('action', '{{ route('admin.blog.delete') }}?idBlog=' +
                id); // Thiết lập action cho form
        });

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
