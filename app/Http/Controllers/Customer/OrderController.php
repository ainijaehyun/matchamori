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

     public function confirmReceived(string $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        // Hanya pesanan yang sedang dikirim yang bisa dikonfirmasi
        if ($order->order_status !== 'On Delivery') {
            return back()->with(
                'error',
                'Pesanan belum dapat dikonfirmasi sebagai pesanan yang diterima.'
            );
        }

        $order->update([
            'order_status' => 'Delivered',
            'payment_status' => 'Paid',
        ]);

        return redirect()
            ->route('customer.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dikonfirmasi sudah diterima.');
    }
}
