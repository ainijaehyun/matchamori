<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        //menampilkan best seller dengan total quantity terjual terbanyak
        $bestSellers = Product::select('products.*')
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.order_status', 'Delivered')
            ->selectRaw('SUM(order_details.quantity) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();
    

        return view('customers.dashboard', compact('categories', 'bestSellers'));
    }
}
