<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOder;
use App\Models\User;
use Carbon\Carbon;
use App\Models\MessOrder;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Tổng doanh thu
        // $totalRevenue = Order::sum('sum_price');
        $totalRevenue = Order::where('status', 4)->sum('sum_price');


        // Tổng sản phẩm bán ra
        // $totalProductsSold = ProductOder::sum('quantity');

        $totalProductsSold = ProductOder::whereHas('Order', function ($query) {
            $query->where('status', 4);
        })->sum('quantity');

        // Xác định khoảng thời gian (mặc định là tuần)
        $timePeriod = $request->input('timePeriod', 'week');

        // Tùy chỉnh điều kiện lọc dựa trên thời gian
        // $query = ProductOder::selectRaw('product_id, SUM(quantity) as total_sold')
        // ->groupBy('product_id')
        // ->orderByDesc('total_sold')
        // ->with('product')
        // ->take(5);

        $query = ProductOder::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->whereHas('order', function ($query) {
                $query->where('status', 4);
            })
            ->with('product')
            ->take(5);

        // dd($query->get());

        // if ($timePeriod === 'week') {
        //     $query->where('created_at', '>=', Carbon::now()->startOfWeek());
        // } elseif ($timePeriod === 'month') {
        //     $query->where('created_at', '>=', Carbon::now()->startOfMonth());
        // } elseif ($timePeriod === 'year') {
        //     $query->where('created_at', '>=', Carbon::now()->startOfYear());
        // }

        if ($timePeriod === 'week') {
            $query->where('created_at', '>=', Carbon::now()->startOfWeek())
            ->whereYear('created_at', Carbon::now()->year); // Chỉ lấy tuần trong năm hiện tại
        } elseif ($timePeriod === 'month') {
            $query->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereYear('created_at', Carbon::now()->year); // Chỉ lấy tháng trong năm hiện tại
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

        // $products = Product::withCount(['productOrders as total_sold' => function ($query) {
        //     $query->selectRaw('SUM(quantity)');
        // }])
        // ->having('total_sold', '=', 0) // Sản phẩm chưa được mua
        // ->orHaving('total_sold', '=', ProductOder::min('quantity')) // Sản phẩm có lượng mua thấp nhất
        //     ->get();


        // $products = Product::withCount(['productOrders as total_sold' => function ($query) {
        //     $query->selectRaw('SUM(quantity)');
        // }])
        // ->having('total_sold', '=', 0) // Sản phẩm chưa được mua
        //     ->orHaving('total_sold', '>', 0) // Sản phẩm đã được mua (lọc những sản phẩm có tổng lượng mua > 0)
        //     ->orderByRaw('CASE WHEN total_sold = 0 THEN 0 ELSE 1 END') // Sắp xếp sản phẩm chưa được mua lên đầu
        //     ->orderBy('total_sold', 'asc') // Sắp xếp sản phẩm đã mua từ thấp đến cao
        //     ->get();

        // $products = Product::withCount(['productOrders as total_sold' => function ($query) {
        //     $query->selectRaw('SUM(quantity)')
        //     ->whereHas('order', function ($subQuery) {
        //         $subQuery->where('status', 4); // Chỉ lấy sản phẩm từ các đơn hàng có status = 4
        //     });
        // }])
        // ->having('total_sold', '=', 0) // Sản phẩm chưa được mua (status = 4)
        //     ->orHaving('total_sold', '>', 0) // Sản phẩm đã được mua (status = 4)
        //     ->orderByRaw('CASE WHEN total_sold = 0 THEN 0 ELSE 1 END') // Sắp xếp sản phẩm chưa được mua lên đầu
        //     ->orderBy('total_sold', 'asc') // Sắp xếp sản phẩm đã mua từ thấp đến cao
        //     ->get();


        // $products = Product::withCount(['productOrders as total_sold' => function ($query) {
        //     $query->selectRaw('SUM(quantity)')
        //         ->whereHas('order', function ($subQuery) {
        //             $subQuery->where('status', 4); // Chỉ tính đơn hàng có status = 4
        //         });
        // }])->get();

        // $products_lower = Product::all();
        // $products = Product::withCount(['productOrders as total_sold' => function ($query) {
        //     $query->selectRaw('COALESCE(SUM(quantity), 0)') // Tính tổng số lượng hoặc 0
        //     ->whereHas('order', function ($subQuery) {
        //         $subQuery->where('status', 4); // Chỉ tính đơn hàng có status = 4
        //     });
        // }])->get();

        $products = Product::withCount(['productOrders as total_sold' => function ($query) {
            $query->selectRaw('COALESCE(SUM(quantity), 0)') // Tính tổng số lượng hoặc 0
            ->whereHas('order', function ($subQuery) {
                $subQuery->where('status', 4); // Chỉ tính đơn hàng có status = 4
            });
        }])
        ->orderBy('total_sold', 'asc')
        ->take(5) // Sắp xếp tổng số lượng tăng dần
        ->get();

        $topUsers = User::withCount(['orderLists as successful_orders' => function ($query) {
            $query->whereHas('order', function ($subQuery) {
                $subQuery->where('status', 4); // Đơn hàng thành công
            });
        }])
            ->orderBy('successful_orders', 'desc') // Sắp xếp giảm dần
            ->take(5) // Lấy 10 tài khoản
            ->get();

        // thông báo
        $messages = MessOrder::with('user','order')->get();
        return view('admin.home', compact(
                'totalRevenue',
                'totalProductsSold',
                'topProducts',
                'topRevenueProducts',
                'products',
                'topUsers',
                'messages',
                // 'products_lower'
            ));
    }
    public function chart(Request $request)
    {
        $startDate = $request->input('start_date', null); // Ngày bắt đầu
        $endDate = $request->input('end_date', null);     // Ngày kết thúc
        $filter = $request->input('filter', null);        // Lọc theo (day, week, month, year)

        // Tạo query cho Orders và ProductOrders
        $query = Order::query();
        $productOrders = ProductOder::join('orders', 'product_orders.order_id', '=', 'orders.id')
        ->select('product_orders.*', 'orders.*')
        ->get(); // Lấy dữ liệu thành collection

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
        $messages = MessOrder::with('user','order')->get();
        return view('admin.statistics.chart', compact('data', 'startDate', 'endDate', 'filter','messages'));
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
