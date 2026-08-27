<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //ringkasan data yang ditampilkan di dashboard
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOrders = Order::count();
        $totalSales = Order::where('payment_status', 'paid')->sum('total');

        //grafik sales (monthly)
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')->where('payment_status', 'paid')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->pluck('total', 'month');

        //pie chart Sales by Category
        $salesByCategory = OrderDetail::join('products', 'order_details.product_id', '=', 'products.id')->join('categories', 'products.category_id', '=', 'categories.id')->selectRaw('categories.name as category_name, SUM(order_details.subtotal) as total')->groupBy('categories.name')->pluck('total', 'category_name');
        
        // recent Orders - 5 pesanan terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts','totalCustomers','totalOrders','totalSales','monthlySales','salesByCategory','recentOrders'));
       
    }
}
