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
                            <h4 class="card-title">Restore Product</h4>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.listProducts') }}" class="btn btn-dark mr-2">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Stick</th>
                                            <th>View</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Action</th>
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
                                                    @foreach ($galleries as $gallerie)
                                                        @if ($gallerie->product_id == $value->id)
                                                            <img src="{{ asset($gallerie->image) }}"width="50px"
                                                                height="50px" alt="">
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td> {{ number_format($value->price) }} vnđ </td>
                                                <td> {{ $value->qty }} </td>
                                                <td> {{ $value->view }} </td>
                                                <td> {{ $value->categories ? $value->categories->name : 'No Category' }}
                                                </td>
                                                <td style="width:20%;"> {{ Str::limit($value->description, 20) }} </td>
                                                <td>
                                                    @if ($value->type == '1')
                                                        <span class='badge badge-pill badge-success'> Simple</span>
                                                    @else
                                                        <span class='badge badge-pill badge-secondary'> Configurable </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-dark" data-toggle="modal"
                                                        data-target="#restorePro"
                                                        data-id="{{ $value->id }}">Restore</button>
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#deleteProductAdmin"
                                                        data-id="{{ $value->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($variants as $variant)
                                            <tr>

                                                <td> {{ $variant->product_id }}</td>

                                                <td> {{ $value->name . ' _ '}} <strong>{{ $variant->sku }}</strong> </td>
                                                <td> <img src="{{ asset($variant->image) }}"
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                        alt="">
                                                </td>
                                                <td> {{ number_format($variant->price) }} vnđ </td>
                                                <td> {{ $variant->stock }} </td>
                                                <td> {{ $value->view }} </td>
                                                <td> {{ $value->categories ? $value->categories->name : 'No Category' }}
                                                </td>
                                                <td style="width:20%;"> {{ Str::limit($value->description, 20) }}
                                                </td>
                                                <td>
                                                    <span class='badge badge-pill badge-success'> Simple</span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-dark" data-toggle="modal"
                                                    data-target="#restoreVariant"
                                                    data-id="{{ $variant->id }}">Restore</button>

                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#deleteForceVariant"
                                                        data-id="{{ $variant->id }}">Delete</button>
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
    <div class="modal fade" id="restorePro">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Product</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formRestore">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Are you sure you want to restore this product?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Restore</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- delete --}}
    <div class="modal fade" id="deleteProductAdmin">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formDelete">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <p>You are delete this product</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- delete varinant --}}
    <div class="modal fade" id="deleteForceVariant">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Product Variant</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formDeleteVariant">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <p>You are delete this product</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- restore varinant --}}
    <div class="modal fade" id="restoreVariant">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restor Product Variant</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formRestoreVariant">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Are you sure you want to restore this product variant?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Restore</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('focus-2/focus-2/documentation/main/assets/js/lib/bootstrap.min.js') }}"></script>
    <script>
        $('#restorePro').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút bấm đã kích hoạt modal
            var productId = button.data('id'); // Lấy ID sản phẩm

            var form = $('#formRestore');
            form.attr('action', '{{ route('admin.restoreAction') }}?id=' +
                productId); // Đặt action với route khôi phục sản phẩm
        });
        $('#deleteProductAdmin').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút kích hoạt modal
            var id = button.data('id'); // Lấy giá trị từ thuộc tính data-id
            var modal = $(this); // Khai báo modal
            var formDelete = modal.find('#formDelete'); // Tìm form bên trong modal
            formDelete.attr('action', '{{ route('admin.forceDeleteProduct') }}?idProduct=' +
            id); // Thiết lập action cho form
        });

        $('#restoreVariant').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Nút bấm đã kích hoạt modal
            var productId = button.data('id'); // Lấy ID sản phẩm

            var form = $('#formRestoreVariant');
            form.attr('action', '{{ route('admin.restoreVariantAction') }}?id=' +
                productId); // Đặt action với route khôi phục sản phẩm
        });


        $('#deleteForceVariant').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            var formDelete = modal.find('#formDeleteVariant');
            formDelete.attr('action', '{{ route('admin.forceDeleteVariant') }}?idProduct=' +
                id);
        });
    </script>
@endsection

@push('scriptHome')
@endpush