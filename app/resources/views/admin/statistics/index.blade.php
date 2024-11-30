<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Thống kê</h1>

        <div class="row text-center mb-5">
            <!-- Tổng doanh thu -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng doanh thu</h5>
                        <p class="card-text fs-3">{{ number_format($totalRevenue) }} VND</p>
                    </div>
                </div>
            </div>

            <!-- Tổng sản phẩm bán ra -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng sản phẩm bán ra</h5>
                        <p class="card-text fs-3">{{ $totalProductsSold }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top sản phẩm bán chạy -->
        {{-- <div class="row mb-5">
            <div class="col-lg-4">
                <h3 class="text-center">Top sản phẩm bán chạy (Tuần)</h3>
                <ul class="list-group">
                    @foreach ($topWeekly as $item)
                        <li class="list-group-item">{{ $item->product->name }} - {{ $item->total_sold }} sản phẩm</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-4">
                <h3 class="text-center">Top sản phẩm bán chạy (Tháng)</h3>
                <ul class="list-group">
                    @foreach ($topMonthly as $item)
                        <li class="list-group-item">{{ $item->product->name }} - {{ $item->total_sold }} sản phẩm</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-4">
                <h3 class="text-center">Top sản phẩm bán chạy (Năm)</h3>
                <ul class="list-group">
                    @foreach ($topYearly as $item)
                        <li class="list-group-item">{{ $item->product->name }} - {{ $item->total_sold }} sản phẩm</li>
                    @endforeach
                </ul>
            </div>
        </div> --}}
        <div class="row mb-5">
            <div class="col-lg-12">
                <h3 class="text-center">Top sản phẩm bán chạy</h3>
                <div class="d-flex justify-content-end mb-3">
                    <!-- Dropdown chọn khoảng thời gian -->
                    <select id="timeFilter" class="form-select" style="width: 200px;">
                        <option value="week" selected>Tuần</option>
                        <option value="month">Tháng</option>
                        <option value="year">Năm</option>
                    </select>
                </div>
                <!-- Bảng hiển thị top sản phẩm bán chạy -->
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng bán</th>
                        </tr>
                    </thead>
                    <tbody id="topProductTable">
                        <!-- Nội dung bảng sẽ được cập nhật ở đây -->
                        @foreach ($topWeekly as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->total_sold }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top sản phẩm có doanh thu cao nhất -->
        <div class="mb-5">
            <h3 class="text-center">Top sản phẩm có doanh thu cao nhất</h3>
            <ul class="list-group">
                @foreach ($topRevenueProducts as $item)
                    <li class="list-group-item">
                        {{ $item->product->name }} - {{ number_format($item->total_revenue) }} VND
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Đồ thị -->
        <div class="mb-5">
            <h3 class="text-center">Biểu đồ doanh thu</h3>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tuần', 'Tháng', 'Năm'],
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: [
                        {{ $totalRevenue }},
                        {{ $totalProductsSold }},
                        {{ $topRevenueProducts->sum('total_revenue') }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        document.getElementById('timeFilter').addEventListener('change', function () {
            const timePeriod = this.value; // Lấy giá trị tuần/tháng/năm
            const csrfToken = '{{ csrf_token() }}';

            // Gửi AJAX request đến server để lấy dữ liệu
            fetch("{{ route('top-products-by-time') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ timePeriod: timePeriod })
            })
            .then(response => response.json())
            .then(data => {
                // Xóa nội dung cũ trong bảng
                const tableBody = document.getElementById('topProductTable');
                tableBody.innerHTML = "";

                // Thêm dữ liệu mới vào bảng
                data.forEach((item, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.product.name}</td>
                            <td>${item.total_sold}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
        });
    </script>
</body>

</html>
