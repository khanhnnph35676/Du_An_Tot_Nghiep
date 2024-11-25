@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Edit Category</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input class="form-control" type="text" name="name" value="{{ $category->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="describe">Description:</label>
                                <input class="form-control" type="text" name="describe" value="{{ $category->describe }}">
                            </div>
                            <div class="form-group">
                                <label for="imageUpload">Image:</label>
                                <input type="file" class="form-control-file" name="image" accept="image/*">

                                @if ($category->image)
            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="max-width: 150px;">

                                @endif
                            </div>
                            <button type="submit" class="btn btn-secondary mb-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/product.js') }}"></script>
@endsection
