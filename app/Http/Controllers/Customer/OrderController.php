<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('customers.orders.index', compact('orders'));
    }
    //tampilkan satu detail pesanan
    public function show(string $id)
    {
        $order = Order::with('orderDetails.product')->where('user_id', Auth::id())->findOrFail($id);

        return view('customers.orders.show', compact('order'));
    }
    public function status(string $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        return view('customers.orders.status', compact('order'));
    }
}
