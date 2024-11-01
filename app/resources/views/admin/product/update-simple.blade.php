@extends('admin.layout.default')
@push('styleHome')
    <link href=" {{ asset('focus-2/focus-2/vendor/summernote/summernote.css') }} " rel="stylesheet">
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Hi, welcome back!</h4>
                        <span class="ml-1">Datatable</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.updateProductSimple',$product->id) }}" method="POST" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New Product Configurable</h4>
                                <div class="d-flex">
                                    <a href="{{ route('admin.listProducts') }}" class="btn btn-dark mr-3">Back</a>
                                    <button type="submit" type="submit" class="btn btn-secondary">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8 p-3 mr-4  ml-4 border">
                                        {{-- form thêm cho product --}}
                                        <div class="form-group">
                                            <label for="">Name:</label>
                                            <input type="number"  name="type" value="1" hidden>
                                            <input class="form-control" type="text" name="name" placeholder="Name" value="{{$product->name}}">
                                            @error('name')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quanlity:</label>
                                            <input class="form-control" type="text" name="qty" value="{{$product->qty}}"
                                                placeholder="Quanlity">
                                            @error('qty')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Price:</label>
                                            <input class="form-control" type="text" name="price" placeholder="Price" value="{{$product->price}}">
                                            @error('price')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                         </div>
                                    </div>
                                    <div class="col-3 p-3 border">
                                        <div class="form-group">
                                            <label>Category:</label>
                                            <select class="form-control" id="sel1" name="category_id">
                                                @foreach ($listCategories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{$product->category_id == $category->id? 'selected':''}} >
                                                            {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Ảnh chính --}}
                                        <div class="form-group">
                                            <label for="">Main Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            @error('image')
                                                <div class="alert alert-danger"><strong>Error!</strong> {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <input type="file" class="form-control" name="gallerie_image[]" accept="image/*"multiple>
                                            </div>
                                        </div>
                                        {{-- galleries (ảnh đi kèm) --}}
                                        {{-- <div class="form-group">
                                            <label for="">Galleries</label>
                                            <input type="file" name="image[]" class="form-control" accept="image/*"
                                                multiple>
                                        </div> --}}
                                    </div>
                                    <div class="form-group mt-3" style="width: 100%">
                                        <h5>Description</h5>
                                        <textarea class="summernote" name="description" id="description">
                                            {{$product->description}}
                                        </textarea>
                                        {{-- <input type="hidden" name="description" id="description"> --}}
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('backend/js/product.js') }}"></script>
@endsection

@push('scriptHome')
    <script src=" {{ asset('vendor/global/global.min.js') }} "></script>
    <script src=" {{ asset('js/quixnav-init.js') }} "></script>
    <script src=" {{ asset('js/custom.min.js') }} "></script>
    <!-- Summernote -->
    <script src="{{ asset('focus-2/focus-2/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ asset('focus-2/focus-2/js/plugins-init/summernote-init.js') }}"></script>
@endpush
