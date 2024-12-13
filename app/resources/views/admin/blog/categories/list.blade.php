@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Xin chào, chào mừng trở lại!</h4>
                    <span class="ml-1">Quản lý danh mục blog</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 d-flex justify-content-end align-items-center">
                <a href="{{ route('admin.categories.deleted') }}" class="btn btn-dark">
                    <i class="fa fa-trash mr-1"></i>Thùng rác
                </a>
            </div>
        </div>

        <!-- Danh sách danh mục -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Danh sách danh mục</h2>
                        <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus mr-1"></i>Thêm danh mục mới
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên danh mục</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->blog_categories_name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="btn btn-warning btn-sm mr-2">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $categories->links() }} <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/script.js') }}"></script>
@endsection
