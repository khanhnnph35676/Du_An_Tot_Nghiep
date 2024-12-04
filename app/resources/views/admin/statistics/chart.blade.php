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
            <div class="container">
                <h1>Biểu Đồ Thống Kê</h1>

                <!-- Form lọc -->
                <form method="GET" action="{{ route('admin.chart') }}" class="mb-4">
                    <div class="row">
                        <!-- Chọn khoảng thời gian -->
                        <div class="col-md-3">
                            <label for="start_date">Từ ngày:</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">Đến ngày:</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                        </div>

                        <!-- Hoặc chọn theo ngày, tuần, tháng, năm -->
                        <div class="col-md-3">
                            <label for="filter">Lọc theo:</label>
                            <select name="filter" class="form-control">
                                <option value="" {{ !$filter ? 'selected' : '' }}>Không chọn</option>
                                <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Ngày</option>
                                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Tuần</option>
                                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Tháng</option>
                                <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Năm</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mt-4">Lọc</button>
                        </div>
                    </div>
                </form>

                <!-- Biểu đồ -->
                <canvas id="statisticsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <!--**********************************
                            Content body end
                        ***********************************-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = @json($data);

            // Xử lý dữ liệu cho biểu đồ
            const labels = Object.keys(data);
            const totalRevenue = labels.map(label => data[label].total_revenue ||
            0); // Cung cấp giá trị mặc định là 0 nếu không có dữ liệu
            const totalOrders = labels.map(label => data[label].total_orders ||
            0); // Cung cấp giá trị mặc định là 0 nếu không có dữ liệu
            const totalSold = labels.map(label => data[label].total_sold ||
            0); // Cung cấp giá trị mặc định là 0 nếu không có dữ liệu

            // Cấu hình biểu đồ
            const ctx = document.getElementById('statisticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Chọn loại biểu đồ
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Doanh Thu (VND)',
                            data: totalRevenue,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)', // Màu nền cho Doanh Thu
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Số Đơn Hàng',
                            data: totalOrders,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu nền cho Số Đơn Hàng
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Số Sản phẩm',
                            data: totalSold,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)', // Màu nền cho Số Sản phẩm
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom', // Vị trí legend (chú thích)
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: false, // Ẩn tiêu đề trục X
                                text: 'Thời Gian'
                            }
                        },
                        y: {
                            title: {
                                display: false, // Ẩn tiêu đề trục Y
                                text: 'Giá Trị'
                            },
                            beginAtZero: true,
                            stacked: true // Chế độ chồng các cột
                        }
                    }
                }
            });
        });
    </script>
@endsection

@push('scriptHome')
@endpush
