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
    public function index(Request $request)
    {
        $cart = Cart::with('cartDetails.product')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Your Cart is still empty.');
        }

        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Please select at least one product to checkout.');
        }

        $selectedItems = $cart->cartDetails
            ->whereIn('id', $selectedItems)
            ->values();

        if ($selectedItems->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Selected product is not valid.');
        }

        session([
            'checkout.selected_items' => $selectedItems->pluck('id')->toArray(),
        ]);

        return view('customers.checkout.shipping', [
            'cart' => $cart,
            'selectedItems' => $selectedItems,
        ]);
    }

    //proses checkout dari cart ke order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:20',
        ]);

        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty.');
        }

        //simpan data shipping sementara di session
        session([
            'checkout.shipping' => [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'],
            ],
        ]);

        //lanjut ke payment
        return redirect()->route('customer.checkout.payment');
    }

    public function payment()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        // Kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty.');
        }

        // Kalau belum mengisi shipping
        if (!session()->has('checkout.shipping')) {
            return redirect()->route('customer.checkout.index')->with('error', 'Please complete shipping information first.');
        }

        return view('customers.checkout.payment', compact('cart'));
    }

    public function confirm()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty');
        }

        //kalau shipping belum disis
        if (!session()->has('checkout.shipping')) {
            return redirect()->route('customer.checkout.index')->with('error', 'Please complete shipping information first.');
        }

        return view('customers.checkout.confirm', compact('cart'));
    }

    public function placeOrder()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty');
        }

        //ambil data shipping dari session
        $shipping = session('checkout.shipping');

        if (!$shipping) {
            return redirect()->route('customer.checkout.index')->with('error', 'Please complete shipping information first.');
        }

        //buat order dalam database transaction
        $order = DB::transaction(function () use ($cart, $shipping) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice' => 'INV-' . strtoupper(Str::random(10)),
                'shipping' => 
                    "Name: " . $shipping['name'] .
                    ", Phone: " . $shipping['phone'] . 
                    ", Address: " . $shipping['address'],
                'postal_code' => $shipping['postal_code'],
                'total' => $cart->total,
                'payment_status' => 'unpaid',
                'order_status' => 'Order Placed',
            ]);

            //pindahkan cart detail ke order detail
            foreach ($cart->cartDetails as $item) {
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);

                //kurangi stock
                $item->product->decrement(
                    'stock',
                    $item->quantity
                );
            }

            //kosongkan cart
            $cart->cartDetails()->delete();
            $cart->update([
                'total' => 0,
            ]);

            return $order;
        });

        //hapus data checkout dari session
        session()->forget('checkout.shipping');

        //pergi ke halaman confirmation
        return redirect()->route('customer.checkout.confirmation', $order->id)->with('success', 'Checkout successful!');

    }

    // HALAMAN CONFIRMATION
    public function confirmation($id)
    {
        $order = Order::with('orderDetails.product')>where('user_id', Auth::id())->findOrFail($id);

        return view('customers.checkout.confirmation', compact('order'));
    }

        // // Gunakan Database Transaction: semua proses di bawah ini
        // // dianggap SATU kesatuan. Kalau ada yang gagal di tengah jalan,
        // // SEMUA perubahan dibatalkan (rollback), tidak ada data setengah jadi.
        // $order = DB::transaction(function () use ($cart, $validated) {
        //     //buat order baru
        //     $order = Order::create([
        //         'user_id' => Auth::id(),
        //         'invoice' => 'INV-' . strtoupper(Str::random(10)),
        //         'shipping' => $validated['shipping'],
        //         'postal_code' => $validated['postal_code'],
        //         'total' => $cart->total,
        //         'payment_status' => 'unpaid',
        //         'order_status' => 'order placed',
        //     ]);

        //     //pindahkan setiap CartDetail menjadi Order Detail
        //     foreach ($cart->cartDetails as $item) {
        //         OrderDetail::create([
        //             'order_id' => $order->id,
        //             'product_id' => $item->product_id,
        //             'quantity' => $item->quantity,
        //             'price' => $item->price,
        //             'subtotal' => $item->subtotal,
        //         ]);
            

        //         //kurangi stok produk sesuai quantity yang dibeli
        //         $item->product->decrement('stock', $item->quantity);
        //     }

        //     //kosongkan cart(hapus semua cart_details)
        //     $cart->cartDetails()->delete();
        //     $cart->update(['total' => 0]);

        //     return $order;
        // });

        // return redirect()->route('customer.orders.show', $order->id)->with('success', 'Checkout successful! Your order is being processed.');
    
}
