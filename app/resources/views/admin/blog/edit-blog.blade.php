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
                        <div class="empty-cart-page section-padding-5">
                            {{-- <div class="container"> --}}
                            <div class="content-page">
                                <div class="container-fluid add-form-list">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" id="form-add-blog" data-toggle="validator"
                                                        enctype="multipart/form-data"
                                                        action="{{ route('admin.blog.submit-edit-blog', ['idBlog' => $blog->idBlog]) }}">
                                                        @csrf
                                                        @method('patch')
                                                        <div class="card-header d-flex justify-content-between">
                                                            <h2>Chỉnh sửa bài viết</h2>
                                                            <div class="d-flex">
                                                                <a href="{{ route('admin.blog.list') }}"
                                                                    class="btn btn-dark mr-3">Trở về</a>
                                                                <input type="submit" class="btn btn-secondary"
                                                                    id="btn-submit" value="Sửa tin tức">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <label>Tiêu đề *</label>
                                                                    <input type="text" name="BlogTitle"
                                                                        value="{{ $blog->BlogTitle }}"
                                                                        class="form-control slug" onkeyup="ChangeToSlug()"
                                                                        placeholder="Nhập tiêu đề tin tức" required>
                                                                    <div class="help-block with-errors"></div>
                                                                    @error('BlogTitle')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <input type="hidden" name="BlogSlug"
                                                                    value="{{ $blog->BlogSlug }}" class="form-control"
                                                                    id="convert_slug">

                                                                <div class="form-group">
                                                                    <label>Ảnh tin tức *</label>
                                                                    <input type="file" name="BlogImage" id="images"
                                                                        onchange="loadPreview(this)"
                                                                        class="form-control image-file">
                                                                    <div class="text-danger alert-img"></div>
                                                                    <div class="d-flex flex-wrap" id="image-list">
                                                                        <div id="image-item-0" class="image-item">
                                                                            <img src="{{ asset('/storage/images/blog/' . $blog->BlogImage) }}"
                                                                                class="img-fluid rounded avatar-100 mr-3 mt-2"
                                                                                style="width: auto; height: 200px; object-fit: cover;">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Mô tả ngắn *</label>
                                                                    <textarea class="form-control" name="BlogDesc">{{ $blog->BlogDesc }}</textarea>
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            CKEDITOR.replace('BlogDesc');
                                                                        });
                                                                    </script>
                                                                    <div class="text-danger alert-desblog"></div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Nội dung *</label>
                                                                    <textarea class="form-control" name="BlogContent">{{ $blog->BlogContent }}</textarea>
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            CKEDITOR.replace('BlogContent');
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label>Trạng thái *</label>
                                                                    <select class="selectpicker form-control"
                                                                        data-style="py-0" name="Status">
                                                                        <option value="0"
                                                                            {{ $blog->Status == 0 ? 'selected' : '' }}>Ẩn
                                                                        </option>
                                                                        <option value="1"
                                                                            {{ $blog->Status == 1 ? 'selected' : '' }}>Hiện
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Danh mục *</label>
                                                                    <select class="selectpicker form-control"
                                                                        data-style="py-0" name="blog_category_id">
                                                                        @foreach ($blog_categories as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $blog->blog_category_id  == $item->id ? 'selected' : '' }}>{{ $item->blog_categories_name }}</option>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
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
