<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong, belum nambah produk
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty');
        }

        return view('customer.checkout.index', compact('cart'));
    }

    //proses checkout dari cart ke order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping' => 'required|string|max:20',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty.');
        }

        // Gunakan Database Transaction: semua proses di bawah ini
        // dianggap SATU kesatuan. Kalau ada yang gagal di tengah jalan,
        // SEMUA perubahan dibatalkan (rollback), tidak ada data setengah jadi.
        $order = DB::transaction(function () use ($cart, $validated) {
            //buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice' => 'INV-' . strtoupper(Str::random(10)),
                'shipping' => $validated['shipping'],
                'postal_code' => $validated['postal_code'],
                'total' => $cart->total,
                'payment_status' => 'unpaid',
                'order_status' => 'order placed',
            ]);

            //pindahkan setiap CartDetail menjadi Order Detail
            foreach ($cart->cartDetails as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            

                //kurangi stok produk sesuai quantity yang dibeli
                $item->product->decrement('stock', $item->quantity);
            }

            //kosongkan cart(hapus semua cart_details)
            $cart->cartDetails()->delete();
            $cart->update(['total' => 0]);

            return $order;
        });

        return redirect()->route('customer.orders.show', $order->id)->with('success', 'Checkout successful! Your order is being processed.');
    }
}
