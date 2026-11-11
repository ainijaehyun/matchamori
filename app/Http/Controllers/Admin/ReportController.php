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
        $currentDate = now();

        // Filter bulan dan tahun
        $year = (int) $request->input('year', $currentDate->year);
        $year = max(2000, min($year, $currentDate->year));

        $maxMonth = ($year === $currentDate->year)
        ? $currentDate->month
        : 12;

        $month = (int) $request->input('month', $currentDate->month);
        $month = max(1, min($month, $maxMonth));

        // Tentukan tanggal terakhir yang boleh dipilih
        $monthDate = \Carbon\Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $monthDate->daysInMonth;

        $maxDay = (
            $year === $currentDate->year
            && $month === $currentDate->month
        ) ? $currentDate->day : $daysInMonth;

        // Filter tanggal: default hari ini untuk bulan berjalan,
        // atau hari terakhir bulan jika memilih bulan lampau
        $day = (int) $request->input('day', $maxDay);
        $day = max(1, min($day, $maxDay));

        $selectedDate = \Carbon\Carbon::createFromDate(
            $year,
            $month,
            $day
        );

        // Data transaksi dihitung dari awal bulan sampai tanggal terpilih
        $startDate = $monthDate->copy()->startOfDay();
        $endDate = $selectedDate->copy()->endOfDay();

        $paidOrders = Order::where('payment_status', 'Paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        //Total Sales & Total Order sesuai bulan yang difilter dan sudah Paid
        $totalSales = Order::where('payment_status', 'Paid')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('total');
        $totalOrders = Order::where('payment_status', 'Paid')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        // Grafik penjualan per hari sampai tanggal yang dipilih
        $dailySales = (clone $paidOrders)
            ->selectRaw('DAY(created_at) as day, SUM(total) as total')
            ->groupByRaw('DAY(created_at)')
            ->pluck('total', 'day');

        $salesChartLabels = [];
        $salesChartData = [];

        for ($i = 1; $i <= $day; $i++) {
            $salesChartLabels[] = (string) $i;
            $salesChartData[] = (float) ($dailySales[$i] ?? 0);
        }

        //Sales by Category
        //Semua kategori tetap ditampilkan
        //Jika suatu kategori belum memiliki penjualan pada bulan tersebut, nilainya akan menjadi 0
       $salesByCategory = Category::leftJoin(
            'products',
            'categories.id',
            '=',
            'products.category_id'
        )
        ->leftJoin(
            'order_details',
            'products.id',
            '=',
            'order_details.product_id'
        )
        ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
            $join->on(
                'order_details.order_id',
                '=',
                'orders.id'
            )
            ->where('orders.payment_status', 'Paid')
            ->whereBetween('orders.created_at', [
                $startDate,
                $endDate
            ]);
        })
        ->select('categories.name as category_name')
        ->selectRaw('COALESCE(SUM(
            CASE
                WHEN orders.id IS NOT NULL
                THEN order_details.subtotal
                ELSE 0
            END
        ), 0) as total')
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

        $orders = Order::with('user')
            ->where('payment_status', 'Paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('admin.reports.index', compact('totalSales','totalOrders','salesByCategory','recapPerMonth', 'orders', 'month','year', 'day', 'maxDay', 'currentDate', 'salesChartLabels', 'salesChartData'));
    }

    public function exportPdf(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        // Ambil pesanan Paid pada periode terpilih
        $orders = Order::with('user')
            ->where('payment_status', 'Paid')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at')
            ->get();

        // Ringkasan penjualan
        $totalSales = $orders->sum('total');
        $totalOrders = $orders->count();

        $averageOrder = $totalOrders > 0
            ? $totalSales / $totalOrders
            : 0;

        $monthName = \Carbon\Carbon::createFromDate(
            $year,
            $month,
            1
        )->translatedFormat('F');

        // Rekap bulanan untuk halaman kedua
        $recapPerMonth = Order::selectRaw(
            'YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total_order,
            SUM(total) as total_sales'
        )
            ->where('payment_status', 'Paid')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->take(10)
            ->get()
            ->sortBy(function ($item) {
                return sprintf(
                    '%04d-%02d',
                    $item->year,
                    $item->month
                );
            })
            ->values();

        return view('admin.reports.pdf', compact(
            'orders',
            'totalSales',
            'totalOrders',
            'averageOrder',
            'month',
            'year',
            'monthName',
            'recapPerMonth'
        ));
    }

}

