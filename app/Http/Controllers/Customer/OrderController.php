<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id());

        $statusMap = [
            'placed' => 'Order Placed',
            'processing' => 'Processing',
            'delivery' => 'On Delivery',
            'delivered' => 'Delivered',
        ];

        $status = $request->query('status');

        if (isset($statusMap[$status])) {
            $query->where('order_status', $statusMap[$status]);
        }

        $orders = $query->latest()->get();

        return view('customers.orders.index', compact('orders', 'status'));
    }

    // Tampilkan satu detail pesanan
    public function show(string $id)
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customers.orders.show', compact('order'));
    }

    // Konfirmasi pesanan sudah diterima atau diambil
    public function confirmReceived(string $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (trim($order->order_status ?? '') !== 'On Delivery') {
            return back()->with('error', 'Pesanan belum dapat dikonfirmasi.');
        }

        $isPickup = str_contains(
            $order->shipping ?? '',
            'Method: Pickup at Matcha Mori Store'
        );

        $order->update([
            'order_status' => 'Delivered',
            'payment_status' => 'Paid',
        ]);

        return redirect()->route('customer.orders.index')
            ->with(
                'success',
                $isPickup
                    ? 'Pesanan berhasil dikonfirmasi sudah diambil.'
                    : 'Pesanan berhasil dikonfirmasi sudah diterima.'
            );
    }
}
