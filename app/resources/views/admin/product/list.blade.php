@extends('admin.layout.default')
@push('styleHome')
    <!-- Datatable -->
@endpush
@section('content')
    <!--**********************************Content body start***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Xin chào, chào mừng trở lại!</h4>
                        <span class="ml-1">Danh sách sản phẩm</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Danh sách sản phẩm</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách sản phẩm</h4>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.restorProduct') }}" class="btn btn-dark mr-2">
                                    <i class="fa fa-trash mr-1"></i>Thùng rác</a>
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Thêm sản phẩm</button>
                                <div class="dropdown-menu bg-secondary mr-4">
                                    <div class="d-flex flex-column p-1">
                                        <a href="{{ route('admin.productSimple') }}" class='btn btn-secondary'>Sản phẩm đơn thể</a>
                                        <a href="{{ route('admin.productDetail') }}" class='btn btn-secondary'>Sản phẩm có biến thể</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Tến sản phẩm</th>
                                            <th>Ảnh</th>
                                            <th>Giá</th>
                                            <th>Tồn kho</th>
                                            <th>Lượt xem</th>
                                            <th>Danh mục</th>
                                            <th>Nội dung</th>
                                            <th>Loại</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listProducts as $key => $value)
                                            <tr>
                                                <td> {{ $value->id }} </td>
                                                <td> {{ $value->name }} </td>
                                                <td> <img src="{{ asset($value->image) }}"
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                        alt="">
                                                    @php
                                                        $count = 0;
                                                    @endphp

                                                    @foreach ($galleries as $gallerie)
                                                        @if ($gallerie->product_id == $value->id && $count < 2)
                                                            <img src="{{ asset($gallerie->image) }}"
                                                                style="width: 50px; height: 50px; object-fit: cover;"
                                                                alt="">
                                                            @php
                                                                $count++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if ($count == 2)
                                                        . . .
                                                    @endif
                                                </td>
                                                <td> {{ number_format($value->price) }} vnđ </td>
                                                <td> {{ $value->qty }} </td>
                                                <td> {{ $value->view }} </td>
                                                <td> {{ $value->categories ? $value->categories->name : 'Không có danh mục' }}
                                                </td>
                                                <td>{{ Str::limit(html_entity_decode(strip_tags($value->description)), 20) }}
                                                </td>

                                                <td>
                                                    @if ($value->type == '1')
                                                        <span class='badge badge-pill badge-success'> Đơn thể</span>
                                                    @else
                                                        <span class='badge badge-pill badge-secondary'> Có biến thể </span>
                                                        @php
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($variants as $variant)
                                                            @if ($variant->product_id == $value->id)
                                                                @php
                                                                    $count++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        <span class='badge badge-pill badge-secondary'> {{ $count++ }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->type == '1')
                                                        <a
                                                            href="{{ route('admin.formUpdateProductSimple', ['type' => $value->type, 'idProduct' => $value->id]) }}"class='btn btn-secondary'>Sửa
                                                        </a>
                                                    @else
                                                        <a
                                                            href="{{ route('admin.formUpdateProductConfigurable', ['type' => $value->type, 'idProduct' => $value->id]) }}"class='btn btn-secondary'>Sửa
                                                        </a>
                                                    @endif
                                                    <!-- Button trigger modal -->
                                                    <button class="btn btn-dark" data-toggle="modal"
                                                        data-target="#deleteProductAdmin"
                                                        data-id="{{ $value->id }}">Xoá</button>
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
    </div>
    <!--**********************************Content body end ***********************************-->

    <!-- Modal -->
    <div class="modal fade" id="deleteProductAdmin">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formDelete">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <p>Bạn có muốn xoá sản phẩm này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteVariant">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formDeleteVariant">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <p>Bạn có muốn xoá sản phẩm biến thể này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('focus-2/focus-2/documentation/main/assets/js/lib/bootstrap.min.js') }}"></script>
    <script>
        $('#deleteProductAdmin').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút kích hoạt modal
            var id = button.data('id'); // Lấy giá trị từ thuộc tính data-id
            var modal = $(this); // Khai báo modal
            var formDelete = modal.find('#formDelete'); // Tìm form bên trong modal
            formDelete.attr('action', '{{ route('admin.deleteProductSimple') }}?idProduct=' +
                id); // Thiết lập action cho form
        });
        $('#deleteVariant').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút kích hoạt modal
            var id = button.data('id'); // Lấy giá trị từ thuộc tính data-id
            var modal = $(this); // Khai báo modal
            var formDelete = modal.find('#formDeleteVariant'); // Tìm form bên trong modal
            formDelete.attr('action', '{{ route('admin.deleteVariant') }}?idProduct=' +
                id); // Thiết lập action cho form
        });
    </script>
@endsection

@push('scriptHome')
@endpush
