<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        //menampilkan best seller dengan total quantity terjual terbanyak
        $bestSellerIds = OrderDetail::selectRaw('product_id, SUM(quantity) as total_sold')->groupBy('product_id')->orderByDesc('total_sold')->take(4)->pluck('product_id');

        $bestSellers = Product::whereIn('id', $bestSellerIds)->get();
    

        return view('customer.dashboard', compact('categories', 'bestSellers'));
    }
}
