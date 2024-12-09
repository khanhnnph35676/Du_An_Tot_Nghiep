@extends('admin.layout.default')
@push('styleHome')
@endpush
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>

    <!--**********************************
                Content body start
            ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-two card-body">
                            <div class="stat-content">
                                <div class="stat-text">Tổng doanh thu </div>
                                <div class="stat-digit">{{ number_format($totalRevenue) }} VND</div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success w-85" role="progressbar" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Tổng sản phẩm bán ra</div>
                                    <div class="stat-digit"> <i class="fa fa-usd"></i>7800</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary w-75" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-two card-body">
                            <div class="stat-content">
                                <div class="stat-text">Tổng sản phẩm bán ra</div>
                                <div class="stat-digit"> {{ $totalProductsSold }}</div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning w-50" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="m-t-10">
                                <h4 class="card-title">Top 5 sản phẩm bán chạy</h4>
                            </div>
                            <div class="widget-card-circle">
                                <div class="row">
                                    <!-- Top sản phẩm bán chạy -->
                                    <div class="row mb-2">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-end mb-3">
                                                <select id="timeFilter" class="form-select form-control"
                                                    style="width: 200px;">
                                                    <option value="week" selected>Tuần</option>
                                                    <option value="month">Tháng</option>
                                                    <option value="year">Năm</option>
                                                </select>
                                            </div>
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-dark">STT</th>
                                                        <th class="text-dark">Ảnh sản phẩm</th>
                                                        <th class="text-dark">Tên sản phẩm</th>
                                                        <th class="text-dark">Số lượng bán</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="topProductTable">
                                                    @foreach ($topProducts as $key => $item)
                                                        <tr>
                                                            <td class="text-dark">{{ $key + 1 }}
                                                            <td><img src="{{ $item->product->image }}" alt=""
                                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                            </td>
                                                            <td class="text-dark">{{ $item->product->name }}</td>
                                                            <td class="text-dark">{{ $item->total_sold }}</td>
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
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="m-t-10">
                                <h4 class="card-title">Top sản phẩm có số lượng bán thấp nhất</h4>
                            </div>
                            <div class="widget-card-circle">
                                <table class="table table-bordered table-striped mt-3">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Ảnh sản phẩm</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Số lượng đã bán</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $index => $product)
                                            <tr>
                                                <td class="text-dark">{{ $index + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset($product->image)  }}" alt="Ảnh sản phẩm" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                </td>
                                                <td class="text-dark">{{ $product->name }}</td>
                                                <td class="text-dark">{{ $product->total_sold ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="m-t-10">
                                <h4 class="card-title">Top tài khoản có lượt mua nhiều nhất</h4>
                            </div>
                            <div class="widget-card-circle">
                                <div class="row">
                                    <!-- Top sản phẩm bán chạy -->
                                    <div class="row mb-2">
                                        <div class="col-lg-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-dark">#</th>
                                                        <th class="text-dark">User Name</th>
                                                        <th class="text-dark">Email</th>
                                                        <th class="text-dark">Successful Orders</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($topUsers as $index => $user)
                                                        <tr>
                                                            <td class="text-dark">{{ $index + 1 }}</td>
                                                            <td class="text-dark">{{ $user->name }}</td>
                                                            <td class="text-dark">{{ $user->email }}</td>
                                                            <td class="text-dark">{{ $user->successful_orders }}</td>
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
            </div>
            {{-- <div class="col-lg-12">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Doanh Thu Cửa Hàng</h4>
                        </div>
                        <form class="col-lg-6 p-0"> @csrf
                            <div class="row">
                                <input type='text' name="DateFrom" id='DateFrom' placeholder="Từ ngày"
                                    class="form-control ml-2" style="width:44%;" />
                                <input type='text' name="DateTo" id='DateTo' placeholder="Đến ngày"
                                    class="form-control ml-2" style="width:44%;" />
                                <button type="button" class="badge badge-info p-0 statistic-btn"
                                    style="border:none; width:7%; margin-left:12px; font-size:20px;" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="Tìm kiếm"><i
                                        class="ri-search-line"></i>
                                </button>
                            </div>
                        </form>
                        <form class="col-lg-3 p-0"> @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="chart-by-days">Lọc theo</label>
                                </div>
                                <select class="custom-select" id="chart-by-days">
                                    <option value="lastweek">7 ngày qua</option>
                                    <option value="lastmonth">30 ngày qua</option>
                                    <option value="lastyear">365 ngày qua</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="chart-sale" style="height: 250px;"></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!--**********************************
                Content body end
            ***********************************-->
    <script>
        document.getElementById('timeFilter').addEventListener('change', function() {
            const timePeriod = this.value; // Lấy giá trị từ dropdown

            // Gửi AJAX request với phương thức GET
            fetch(`{{ route('admin.admin1') }}?timePeriod=${timePeriod}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('topProductTable');
                    tableBody.innerHTML = "";

                    // Cập nhật bảng với dữ liệu mới
                    data.forEach((item, index) => {
                        const row = `
                            <tr>
                                <td class="text-dark">${index + 1}</td>
                                <td><img src=" {{ asset($product->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                <td class="text-dark">${item.product.name}</td>
                                <td class="text-dark">${item.total_sold}</td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(error => console.error("Error fetching data:", error));
        });
    </script>
    {{-- {{ $item->product->image }} --}}
@endsection

@push('scriptHome')
@endpush
