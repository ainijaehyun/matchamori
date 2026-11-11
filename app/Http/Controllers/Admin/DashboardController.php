<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ringkasan data dashboard
        $totalProducts = Product::count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalOrders = Order::count();

        $totalSales = Order::where('payment_status', 'Paid')->sum('total');

        // Filter bulan dan tahun
        $currentDate = now();

        $year = (int) $request->input('year', $currentDate->year);
        $month = (int) $request->input('month', $currentDate->month);

        // Batasi tahun agar tidak memilih tahun mendatang
        $year = max(2000, min($year, $currentDate->year));

        // Batasi bulan sesuai tahun yang dipilih
        $maxMonth = ($year === $currentDate->year)
            ? $currentDate->month
            : 12;

        $month = max(1, min($month, $maxMonth));

        // Menentukan jumlah hari dalam bulan yang dipilih
        $selectedDate = Carbon::createFromDate($year, $month, 1);

        $daysInMonth = $selectedDate->daysInMonth;

        // Jika bulan dan tahun saat ini, tampilkan sampai hari ini saja
        if ($year === $currentDate->year
            && $month === $currentDate->month) {
            $lastDay = $currentDate->day;
        } else {
            $lastDay = $daysInMonth;
        }

        // Grafik penjualan per hari
        $dailySales = Order::selectRaw(
                'DAY(created_at) as day, SUM(total) as total'
            )
            ->where('payment_status', 'Paid')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', '<=', $lastDay)
            ->groupByRaw('DAY(created_at)')
            ->pluck('total', 'day');

        // Menyiapkan label tanggal dan total penjualan
        $salesChartLabels = [];
        $salesChartData = [];

        for ($day = 1; $day <= $lastDay; $day++) {
            $salesChartLabels[] = (string) $day;
            $salesChartData[] = (float) ($dailySales[$day] ?? 0);
        }

        // Grafik penjualan berdasarkan kategori
        // Mengikuti filter bulan dan tahun yang dipilih
        $salesByCategory = OrderDetail::join(
                'orders',
                'order_details.order_id',
                '=',
                'orders.id'
            )
            ->join(
                'products',
                'order_details.product_id',
                '=',
                'products.id'
            )
            ->join(
                'categories',
                'products.category_id',
                '=',
                'categories.id'
            )
            ->where('orders.payment_status', 'Paid')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
            ->selectRaw(
                'categories.name as category_name,
                SUM(order_details.subtotal) as total'
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.id')
            ->get();

        // Recent Orders: 5 pesanan terbaru yang Delivered
        $recentOrders = Order::with('user')
            ->where('order_status', 'Delivered')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'totalSales',
            'salesByCategory',
            'recentOrders',
            'salesChartLabels',
            'salesChartData',
            'month',
            'year',
            'lastDay',
            'currentDate'
        ));
    }
}
