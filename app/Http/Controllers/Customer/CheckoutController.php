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

    // Ambil ID produk yang dipilih dari Cart
    $selectedIds = $request->input('selected_items');

    if (!$selectedIds) {
        return redirect()
            ->route('customer.cart.index')
            ->with('error', 'Please select a product first.');
    }

    // Ubah "1,3,5" menjadi array [1, 3, 5]
    $selectedIds = explode(',', $selectedIds);

    // Ambil hanya cart detail yang dipilih
    $selectedItems = $cart->cartDetails
        ->whereIn('id', $selectedIds)
        ->values();

    if ($selectedItems->isEmpty()) {
        return redirect()
            ->route('customer.cart.index')
            ->with('error', 'Selected product is not valid.');
    }

    // Simpan ID produk yang dipilih ke session
    session([
        'checkout.selected_items' => $selectedItems->pluck('id')->toArray(),
    ]);

    // Hitung total hanya dari produk yang dipilih
    $checkoutTotal = $selectedItems->sum('subtotal');

    $user = Auth::user();
    return view('customers.checkout.orderform', [
        'cart' => $cart,
        'selectedItems' => $selectedItems,
        'checkoutTotal' => $checkoutTotal,
        'user' => $user,
    ]);
}

    //proses checkout dari cart ke order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:20',
            'courier' => 'required|in:GrabExpress,GoSend',
            'delivery_service' => 'required|in:Instant,Same Day',
            'payment_method' => 'required|in:COD',
        ]);

        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty.');
        }

        //simpan data shipping sementara di session
        session([
            'checkout.order_form' => [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'],
                'courier' => $validated['courier'],
                'delivery_service' => $validated['delivery_service'],
                'payment_method' => $validated['payment_method'],
            ],
        ]);

        //lanjut ke payment
        return redirect()->route('customer.checkout.confirm');
    }

    public function confirm()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty');
        }

        $selectedIds = session('checkout.selected_items', []);

        //ambil data order form dari session
        $orderForm = session('checkout.order_form');

         if (empty($selectedIds) || !$orderForm) {

            return redirect()->route('customer.checkout.index')->with('error','Please complete the order form first.');
        }
        //ambil hanya produk ynag dipilih
        $selectedItems = $cart->cartDetails->whereIn('id', $selectedIds)->values();

        if ($selectedItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Selected product is not valid.');
        }

        //hitung total produk yang dipilih
        $checkoutTotal = $selectedItems->sum('subtotal');


        return view('customers.checkout.confirm', [
            'cart' => $cart,
            'selectedItems' => $selectedItems,
            'checkoutTotal' => $checkoutTotal,
            'orderForm' => $orderForm,
        ]);
    }

    public function placeOrder()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        //kalau cart kosong
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty');
        }

        //ambil produk yang dipilih
        $selectedIds = session('checkout.selected_items', []);

        //ambil data order form dari session
        $orderForm = session('checkout.order_form');

        if (empty($selectedIds) || !$orderForm) {
            return redirect()->route('customer.checkout.index')->with('error', 'Please complete shipping information first.');
        }

        //ambil hanya produk ynag dipilih
        $selectedItems = $cart->cartDetails->whereIn('id', $selectedIds)->values();

        if ($selectedItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Selected product is not valid.');
        }

        //hitung total
        $checkoutTotal = $selectedItems->sum('subtotal');

        //buat order dalam database transaction
        $order = DB::transaction(function () use ($cart, $orderForm, $selectedItems, $checkoutTotal) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice' => 'INV-' . strtoupper(Str::random(10)),
                'shipping' => 
                    "Name: " . $orderForm['name'] .
                    ", Phone: " . $orderForm['phone'] . 
                    ", Address: " . $orderForm['address'],
                'postal_code' => $orderForm['postal_code'],
                'courier' => $orderForm['courier'],
                'delivery_service' => $orderForm['delivery_service'],
                'payment_method' => $orderForm['payment_method'],
                'total' => $checkoutTotal,
                'payment_status' => 'Unpaid',
                'order_status' => 'Order Placed',
            ]);

            //pindahkan cart detail ke order detail
            foreach ($selectedItems as $item) {
                
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

                //hpaus hanya item yang sudah dibeli
                $item->delete();
            }

            //hitung ulang total cart
            $cart->update([
                'total' => $cart->cartDetails()->sum('subtotal'),
            ]);

            return $order;
        });

        //hapus data checkout dari session
        session()->forget([
            'checkout.order_form',
            'checkout.selected_items',
        ]);

        //pergi ke halaman confirmation
        return redirect()->route('customer.checkout.confirmation', $order->id)->with('success', 'Checkout successful!');

    }

    // HALAMAN CONFIRMATION
    public function confirmation($id)
    {
        $order = Order::with('orderDetails.product')->where('user_id', Auth::id())->findOrFail($id);

        return view('customers.checkout.confirmation', compact('order'));
    }

}
