<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductOder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Tổng doanh thu
        $totalRevenue = Order::sum('sum_price');

        // Tổng sản phẩm bán ra
        $totalProductsSold = ProductOder::sum('quantity');

        // Xác định khoảng thời gian (mặc định là tuần)
        $timePeriod = $request->input('timePeriod', 'week');

        // Tùy chỉnh điều kiện lọc dựa trên thời gian
        $query = ProductOder::selectRaw('product_id, SUM(quantity) as total_sold')
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->with('product')
        ->take(5);

        if ($timePeriod === 'week') {
            $query->where('created_at', '>=', Carbon::now()->startOfWeek());
        } elseif ($timePeriod === 'month') {
            $query->where('created_at', '>=', Carbon::now()->startOfMonth());
        } elseif ($timePeriod === 'year') {
            $query->where('created_at', '>=', Carbon::now()->startOfYear());
        }

        $topProducts = $query->get();
        // dd($topProducts);

        // Nếu yêu cầu từ AJAX, trả về dữ liệu JSON
        if ($request->ajax()) {
            return response()->json($topProducts);
        }

        // Top sản phẩm có doanh thu cao nhất
        $topRevenueProducts = ProductOder::selectRaw('product_id, SUM(price * quantity) as total_revenue')
        ->groupBy('product_id')
        ->orderByDesc('total_revenue')
        ->with('product')
        ->take(5)
            ->get();

        return view('admin.home', compact(
                'totalRevenue',
                'totalProductsSold',
                'topProducts',
                'topRevenueProducts'
            ));
    }
    public function chart(Request $request)
    {
        $startDate = $request->input('start_date', null); // Ngày bắt đầu
        $endDate = $request->input('end_date', null);     // Ngày kết thúc
        $filter = $request->input('filter', null);        // Lọc theo (day, week, month, year)

        // Tạo query cho Orders và ProductOrders
        $query = Order::query();
        $productOrders = ProductOder::join('orders', 'product_orders.order_id', '=', 'orders.id');

        // Nếu có ngày bắt đầu và kết thúc, lọc theo khoảng thời gian
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $productOrders->whereBetween('orders.created_at', [$startDate, $endDate]);
        } elseif ($filter) {
            // Lọc theo tuần, tháng, năm
            $query->whereBetween('created_at', $this->getDateRangeByFilter($filter));
            $productOrders->whereBetween('orders.created_at', $this->getDateRangeByFilter($filter));
        } else {
            // Mặc định hiển thị theo tháng hiện tại
            $query->whereBetween('created_at', $this->getDateRangeByFilter('month'));
            $productOrders->whereBetween('orders.created_at', $this->getDateRangeByFilter('month'));
        }

        // Lấy dữ liệu và nhóm theo thời gian
        $orders = $query->where('status', '=', 4)->get();
        $data = $orders->groupBy(function ($order) use ($filter) {
            return match ($filter) {
                'day' => Carbon::parse($order->created_at)->format('Y-m-d'),
                'week' => Carbon::parse($order->created_at)->startOfWeek()->format('Y-m-d'),
                'month' => Carbon::parse($order->created_at)->format('Y-m'),
                'year' => Carbon::parse($order->created_at)->format('Y'),
                default => Carbon::parse($order->created_at)->format('Y-m'),
            };
        })->map(function ($group) use ($productOrders) {
            $totalRevenue = $group->sum('sum_price');
            $totalOrders = $group->count();
            $groupOrderIds = $group->pluck('id'); // Lấy danh sách order_id trong group
            $totalSold = $productOrders->whereIn('order_id', $groupOrderIds)->sum('quantity');

            return [
                'time_period' => $group->first()->created_at,
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'total_sold' => $totalSold,
            ];
        });

        return view('admin.statistics.chart', compact('data', 'startDate', 'endDate', 'filter'));
    }

    private function getDateRangeByFilter($filter)
    {
        $now = Carbon::now();

        return match ($filter) {
            'day' => [$now->startOfDay()->toDateTimeString(), $now->endOfDay()->toDateTimeString()],
            'week' => [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()],
            'month' => [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()],
            'year' => [$now->startOfYear()->toDateTimeString(), $now->endOfYear()->toDateTimeString()],
            default => [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()],
        };
    }

}
