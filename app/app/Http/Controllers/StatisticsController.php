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
}
