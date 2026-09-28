<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter bulan dan tahun
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        //Total Sales & Total Order sesuai bulan yang difilter dan sudah Paid
        $totalSales = Order::where('payment_status', 'Paid')->whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total');

        $totalOrders = Order::where('payment_status', 'Paid')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();


        //Grafik Sales (Monthly) menampilkan total sales setiap bulan dan tahun yang dipilih
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')->where('payment_status', 'Paid')->whereYear('created_at', $year) ->groupBy('month')->orderBy('month')->pluck('total', 'month');

        //Sales by Category
        //Semua kategori tetap ditampilkan
        //Jika suatu kategori belum memiliki penjualan pada bulan tersebut, nilainya akan menjadi 0
        $salesByCategory = Category::leftjoin('products', 'categories.id', '=', 'products.category_id')
            ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->leftjoin('orders', 
                        function ($join) use ($month, $year) {
                            $join->on(
                                'order_details.order_id', '=', 'orders.id'
                            )
                            ->where('orders.payment_status', 'Paid')
                            ->whereMonth('orders.created_at', $month)
                            ->whereYear('orders.created_at', $year);
                        } 
                    )
                    ->select('categories.name as category_name')
                    ->selectRaw('COALESCE(SUM(order_details.subtotal), 0) as total')
                    ->groupBy('categories.id', 'categories.name')
                    ->orderBy('categories.id')
                    ->get();


        //Recap per Month - rekap 6 bulan terakhir yang sudah paid
        $recapPerMonth = Order::selectRaw(
               'MONTH(created_at) as month, 
                YEAR(created_at) as year, 
                COUNT(*) as total_order, 
                SUM(total) as total_sales'
            )
            ->where('payment_status', 'Paid')
            ->groupBy('year', 'month')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->take(6)
            ->get();

        return view('admin.reports.index', compact('totalSales','totalOrders','monthlySales','salesByCategory','recapPerMonth','month','year'));
    }
}

