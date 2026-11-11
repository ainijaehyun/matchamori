<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Validasi ulasan
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Pastikan pesanan milik customer yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan pesanan sudah diterima
        if ($order->order_status !== 'Delivered') {
            return back()->with('error', 'Pesanan belum dapat diulas.');
        }

        // Pastikan produk termasuk dalam pesanan
        $productExists = $order->orderDetails()
            ->where('product_id', $validated['product_id'])
            ->exists();

        if (! $productExists) {
            abort(403);
        }

        // Simpan ulasan
        Review::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }
}