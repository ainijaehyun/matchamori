<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }
    //tampilkan satu detail pesanan
    public function show(string $id)
    {
        $order = Order::with('orderDetails.product')->where('user_id', Auth::id())->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }
}
