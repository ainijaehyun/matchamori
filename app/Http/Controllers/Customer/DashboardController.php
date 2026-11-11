<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $products = Product::with('category')->get();

        //menampilkan best seller dengan total quantity terjual terbanyak
        $bestSellers = Product::with(['category', 'reviews.user'])
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.order_status', 'Delivered')
            ->select('products.*')
            ->selectRaw('SUM(order_details.quantity) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();
    

        return view('customers.dashboard', compact('categories', 'products', 'bestSellers'));
    }
}
