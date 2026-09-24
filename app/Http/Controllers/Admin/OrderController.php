<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
    //tampilkan detail satu pesana dan rincianyya
    public function show(string $id)
    {
        $order = Order::with('user', 'orderDetails.product')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
    
    //menampilkan halaman update order status
    public function status(string $id)
    {
        $order = Order::with('user')->findOrFail($id);

        return view('admin.orders.status', compact('order'));
    }


    //update status pesanan
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:Order Placed,Processing,On Delivery,Delivered',
        ]);

        $order = Order::findOrFail($id);

        $order->order_status = $validated['order_status'];

        if ($validated['order_status'] === 'Delivered') {
            $order->payment_status = 'Paid';
        } else {
            $order->payment_status = 'Unpaid';
        }
        
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'order status updated successfully.');
    }
}
