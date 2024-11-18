@extends('admin.layout.default')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <span class="ml-1">Deleted Categories</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 text-right">
                <!-- Nút Trở lại -->
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>

        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Deleted Categories</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($deletedCategories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <h5>{{ $category->name }}</h5>
                                    <div class="d-flex">
                                        <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to restore this category?');">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary mr-3">Restore</button>
                                        </form>

                                        <form action="{{ route('admin.categories.forceDestroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark">Permanently Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
