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
    //update status pesanan
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:order placed, processing, on delivery, delivered'
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'order status updated successfully.');
    }
}
