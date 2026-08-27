<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        //kalau tidak difilter, default-nya bulan & tahun sekarang
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        //total Sales & Total Order sesuai bulan yang difilter
        $totalSales = Order::where('payment_status', 'paid')->whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total');

        $totalOrders = Order::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        //grafik Sales (Monthly) - tetap tampilkan tren sepanjang tahun yang dipilih
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')->where('payment_status', 'paid')->whereYear('created_at', $year) ->groupBy('month')->orderBy('month')->pluck('total', 'month');

        //pie chart Sales by Category, sesuai bulan yang difilter
        $salesByCategory = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')->join('products', 'order_details.product_id', '=', 'products.id')->join('categories', 'products.category_id', '=', 'categories.id')->selectRaw('categories.name as category_name, SUM(order_details.subtotal) as total')->whereMonth('orders.created_at', $month)->whereYear('orders.created_at', $year)->groupBy('categories.name')->pluck('total', 'category_name');

        //recap per Month - rekap 6 bulan terakhir (atau bisa disesuaikan)
        $recapPerMonth = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total_order, SUM(total) as total_sales')->where('payment_status', 'paid')->groupBy('year', 'month')->orderByDesc('year')->orderByDesc('month')->take(6)->get();

        return view('admin.reports.index', compact('totalSales','totalOrders','monthlySales','salesByCategory','recapPerMonth','month','year'));
    }
}

