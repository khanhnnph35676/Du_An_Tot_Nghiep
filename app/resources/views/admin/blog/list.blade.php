@extends('admin.layout.default')

@section('content')
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Danh sách Blog</h4>
                        <div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addPostModal">Thêm Blog mới</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-dark">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Trạng thái</th>
                                    <th>Ảnh chính bài viết</th>
                                    <th>Danh sách ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Nội dung ngắn</th>
                                    <th>Tác giả</th>
                                    <th>Nội dung đầy đủ</th>
                                    <th>Ngày đăng</th>
                                    <th>Danh mục</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->id}}</td>
                                        <td>
                                            @if ($blog->status == 'draft')
                                                Bản nháp
                                            @elseif ($blog->status == 'published')
                                                Đã xuất bản
                                            @elseif ($blog->status == 'archived')
                                                Đã lưu trữ
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ asset('storage/blog_images/' . $blog->blog_image) }}" alt="Ảnh chính" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                        </td>
                                        <td>
                                            @foreach (json_decode($blog->list_image) as $image)
                                                <img src="{{ asset('storage/blog_images/' . $image) }}" alt="Ảnh" style="width: 100px; height: auto; margin: 5px;">
                                            @endforeach
                                        </td>
                                        <td>{{ $blog->title}}</td>
                                        <td>{{ $blog->short_content}}</td>
                                        <td>{{ $blog->author}}</td>
                                        <td>{{ $blog->full_content}}</td>
                                        <td>{{ $blog->published_at}}</td>
                                        <td>{{ $blog->blog->blog_categories_name }}</td>
                                    </tr>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Thêm Blog mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.blog.add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-dark">
                        <div class="form-group">
                            <div class="form-floating">
                                <label for="">Chọn trạng thái: </label>
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="status">
                                    <option selected>Chọn trạng thái</option>
                                    <option value="draft">Bản nháp</option>
                                    <option value="published">Đã xuất bản</option>
                                    <option value="archived">Đã lưu trữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Ảnh chính:</label>
                            <input type="file" class="form-control" name="blog_image" >
                        </div>
                        <div class="form-group">
                            <label for="image">Danh sách ảnh:</label>
                            <input type="file" class="form-control" name="list_image[]" multiple>
                        </div>
                        <div class="form-group">
                            <label for="image">Tiêu đề:</label>
                            <input type="text" class="form-control" name="title" >
                        </div>
                        <div class="form-group">
                            <label for="image">Nội dung ngắn:</label>
                            <textarea name="short_content" class="form-control" id="" cols="5" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Tác giả:</label>
                            <input type="text" class="form-control" name="author" >
                        </div>
                        <div class="form-group">
                            <label for="image">Nội dung đầy đủ:</label>
                            <textarea name="full_content" class="form-control" id="" cols="8" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Danh mục:</label>
                            <select class="form-select" aria-label="Default select example" name="category_id">
                                <option selected>Chọn danh mục</option>
                                @foreach ($blog_categories as $blog_category)
                                <option value="{{$blog_category->id}}">{{$blog_category->blog_categories_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Tạo Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/blog.js') }}"></script>
@endsection
