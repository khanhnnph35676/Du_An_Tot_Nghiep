@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <span class="ml-1">Category Management</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Categories</h4>
                    </div>
                    <div class="card-body row">
                        <div class="col-4 ml-3 mr-5 border">
                            <h5 class="mb-3">List Categories</h5>
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach($categories as $category)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="" width="50px" height="50px">
                                        @else
                                        <img src="#" alt="" width="50px" height="50px">
                                        @endif
                                        <h5>{{ $category->name }}</h5>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="badge badge-success badge-pill mr-1">Update</a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge badge-danger badge-pill">Delete</button>
                                            </form>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-7 border">
                            <h5 class="m-3">Add New Category</h5>
                            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input class="form-control" type="text" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="describe">Description:</label>
                                    <input class="form-control" type="text" name="describe" placeholder="Description">
                                </div>
                                <div class="form-group">
                                    <label for="imageUpload">Image:</label>
                                    <input type="file" class="form-control-file" name="image" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-secondary mb-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/product.js') }}"></script>
@endsection
