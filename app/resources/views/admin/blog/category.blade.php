@extends('admin.layout.default')

@section('content')

<link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
        
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <span class="ml-1">Quản lý thể loại Blog</span>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('insert-message'))
            <div class="alert alert-success">
                <ul>
                    @if(session('insert-message'))
                        <li>{{ session('insert-message') }}</li>
                    @endif
                </ul>
            </div>
        @endif
        @if (session('delete-message'))
            <div class="alert alert-danger">
                <ul>
                    @if(session('delete-message'))
                        <li>{{ session('delete-message') }}</li>
                    @endif
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thể loại</h4>
                    </div>
                    <div class="card-body row">
                        <div class="col-4 ml-3 mr-5 border">
                            <h5 class="mb-3">Danh sách thể loại Blog</h5>
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach($blog_categories as $category)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        
                                        <h5>{{ $category->blog_categories_name}}</h5>
                                        <div class="d-flex">
                                            <form action="{{ route('admin.blog.category.update', $category->id) }}" method="POST"> 
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" value="{{$category->id}}">
                                                <button type="button" class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#ModalUpdateBlogCategories{{$category->id}}">Sửa</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="ModalUpdateBlogCategories{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                                        <button type="button" class=" text-dark btn border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                    </div>
                                                        <div class="modal-body">
                                                            <p class="text-dark" id="new-name">Bạn muốn đổi thể loại "{{ $category->blog_categories_name }}" thành:  <input type="text" name="blog_categories_name"></p>
                                                        </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </form>
                                            
                                            <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger mr-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{$category->id}}">Xóa</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                                        <button type="button" class=" text-dark btn border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-dark">Bạn có chắc chắn muốn xóa thể loại "{{ $category->blog_categories_name}}"?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>

                                            </form>
                                            <button type="button" class="btn btn-success">Detail</button>

                                        </div>
                                    </li>
                                    @endforeach
                                    <li class="list-group-item justify-content-between align-items-center">
                                        <form action="{{route('admin.blog.store')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <input type="hidden" name="id" value="{{$category->id}}">
                                                <div class="col-9">
                                                    <h5><input type="text" class="form-control" placeholder="Nhập tên danh mục Blog"  name="blog_categories_name"></h5>
                                                </div>
                                                <div class="col-3">
                                                    <button type="submit" name="submit" class="btn btn-secondary">Tạo mới</button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                                    {{ $blog_categories->links() }}                               
                            </div>
                        </div>
                        <div class="col-7 border">
                            <h5 class="m-3">Danh sách sản phẩm thể loại ""</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/product.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
  const input1 = document.getElementById('input1');
  const newNameElement = document.getElementById('new-name');

  input1.addEventListener('input', () => {
      newNameElement.textContent += input1.value;
  });
</script>
@endsection
