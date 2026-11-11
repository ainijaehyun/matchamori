<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Address;
use App\Models\Product;
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

            return redirect()->route('customer.cart.index')->with('error', 'Your Cart is still empty.');
        }

        $selectedIds = $request->input(
            'selected_items',
            session('checkout.selected_items', [])
        );

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        if (empty($selectedIds)) {

            return redirect()->route('customer.cart.index')->with('error', 'Please select a product first.');
        }

        $selectedItems = $cart->cartDetails
            ->whereIn('id', $selectedIds)
            ->values();

        if ($selectedItems->isEmpty()) {

            return redirect()->route('customer.cart.index')->with('error', 'Selected product is not valid.');
        }

        session([
            'checkout.selected_items' => $selectedItems->pluck('id')->toArray(),
        ]);

        $checkoutTotal = $selectedItems->sum('subtotal');

        $user = Auth::user();

        $addresses = Address::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        $selectedAddress = $addresses->firstWhere('is_default', true)
            ?? $addresses->first();

        return view('customers.checkout.orderform', compact(
            'cart',
            'selectedItems',
            'checkoutTotal',
            'user',
            'addresses',
            'selectedAddress'
        ));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'delivery_method' => 'required|in:delivery,pickup',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'payment_method' => 'required|in:COD,DANA,GoPay,OVO',
        ]);

        $selectedIds = session('checkout.selected_items', []);

        if (empty($selectedIds)) {
            return response()->json([
                'message' => 'Silakan pilih produk terlebih dahulu.',
            ], 422);
        }

        $cart = Cart::with('cartDetails.product')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Keranjang belanja kosong.',
            ], 422);
        }

        $selectedItems = $cart->cartDetails
            ->whereIn('id', $selectedIds);

        if ($selectedItems->isEmpty()) {
            return response()->json([
                'message' => 'Produk yang dipilih tidak ditemukan.',
            ], 422);
        }

        foreach ($selectedItems as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => 'Stok salah satu produk tidak mencukupi.',
                ], 422);
            }
        }

        // Bersihkan alamat sebelum disimpan.
        if ($validated['delivery_method'] === 'delivery') {
            $validated['address'] = $this->normalizeAddress(
                $validated['address']
            );
        }

        // Simpan data penerima ke akun customer.
        $userData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ];

        if ($validated['delivery_method'] === 'delivery') {
            $userData['address'] = $validated['address'];
        }

        Auth::user()->update($userData);

        // Simpan data form ke session.
        session([
            'checkout.order_form' => $validated,
        ]);

        // COD tetap menuju halaman pembayaran COD.
        if ($validated['payment_method'] === 'COD') {

            return redirect()->route('customer.checkout.payment');

        }

        // Buat nomor transaksi sementara untuk popup.
        $invoice = 'INV-' . strtoupper(Str::random(10));

        session([
            'checkout.transaction_invoice' => $invoice,
        ]);

        $total = $selectedItems->sum('subtotal');

        // E-wallet mengembalikan data JSON untuk ditampilkan di popup.
        return response()->json([
            'success' => true,
            'payment_method' => $validated['payment_method'],
            'invoice' => $invoice,
            'total' => $total,
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }

    public function payment()
    {
        $orderForm = session('checkout.order_form');

        if (!$orderForm) {

            return redirect()->route('customer.checkout.index')->with('error', 'Please complete the checkout form first.');

        }

        // Halaman pembayaran lama hanya digunakan untuk COD.
        if (($orderForm['payment_method'] ?? null) !== 'COD') {

            return redirect()->route('customer.checkout.index');

        }

        $cart = Cart::with('cartDetails.product')
            ->where('user_id', Auth::id())
            ->first();

        $selectedIds = session('checkout.selected_items', []);

        if (!$cart || empty($selectedIds)) {

            return redirect()->route('customer.cart.index')->with('error', 'Please select a product first.');

        }

        $selectedItems = $cart->cartDetails
            ->whereIn('id', $selectedIds)
            ->values();

        if ($selectedItems->isEmpty()) {

            return redirect()->route('customer.cart.index')->with('error', 'Selected product is not valid.');

        }

        $subtotal = $selectedItems->sum('subtotal');
        $shippingCost = 0;
        $total = $subtotal;
        $paymentMethod = 'COD';

        return view('customers.checkout.payment', compact(
            'selectedItems',
            'subtotal',
            'shippingCost',
            'total',
            'paymentMethod',
            'orderForm'
        ));
    }


    public function storePayment(Request $request)
    {
        $orderForm = session('checkout.order_form');

        if (!$orderForm || ($orderForm['payment_method'] ?? null) !== 'COD') {

            return redirect()->route('customer.checkout.index')->with('error', 'Data checkout tidak valid.');

        }

        // COD tidak membutuhkan bukti pembayaran.
        $order = $this->createOrderFromCheckout(
            'COD',
            'Unpaid',
            false
        );

        if (!$order) {
            return redirect()->route('customer.checkout.index')->with('error', 'Pesanan gagal diproses. Silakan periksa keranjang.');
        }

        return redirect()->route('customer.checkout.confirmation', $order->id)->with('success', 'Order submitted successfully!');
    }


    public function simulatePayment(Request $request)
    {
        $orderForm = session('checkout.order_form');
        $selectedIds = session('checkout.selected_items', []);
        $invoice = session('checkout.transaction_invoice');

        if (
            !$orderForm ||
            empty($selectedIds) ||
            !$invoice ||
            !in_array($orderForm['payment_method'] ?? null, ['DANA', 'GoPay', 'OVO'], true)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi pembayaran tidak valid atau sudah digunakan.'
            ], 422);
        }

        $method = $orderForm['payment_method'];

        $order = $this->createOrderFromCheckout(
            $method,
            'Paid',
            true,
            $invoice
        );

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan gagal diproses. Periksa kembali stok produk.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Simulasi pembayaran berhasil!',
            'redirect' => route('customer.checkout.payment.result', $order->id)
        ]);
    }

    
    private function normalizeAddress(string $address): string
    {
        $parts = array_values(array_filter(
            array_map('trim', explode(',', $address)),
            fn ($part) => $part !== ''
        ));

        // Menghapus wilayah yang terulang di bagian akhir.
        // Format wilayah: Desa, Kecamatan, Kabupaten, Provinsi.
        while (count($parts) >= 8) {

            $previousRegion = array_map(
                fn ($item) => mb_strtolower(preg_replace('/\s+/', ' ', $item)),
                array_slice($parts, -8, 4)
            );

            $lastRegion = array_map(
                fn ($item) => mb_strtolower(preg_replace('/\s+/', ' ', $item)),
                array_slice($parts, -4, 4)
            );

            if ($previousRegion === $lastRegion) {
                array_splice($parts, -4);
            } else {
                break;
            }
        }

        return implode(', ', $parts);
    }
   
    private function createOrderFromCheckout(string $method, string $paymentStatus, bool $createPayment, ?string $invoice = null) 
    {
        $orderForm = session('checkout.order_form');
        $selectedIds = session('checkout.selected_items', []);

        if (!$orderForm || empty($selectedIds)) {
            return null;
        }

        try {
            $order = DB::transaction(function () use (
                $orderForm,
                $selectedIds,
                $method,
                $paymentStatus,
                $createPayment,
                $invoice
            ) {
                $cart = Cart::where('user_id', Auth::id())
                    ->lockForUpdate()
                    ->first();

                if (!$cart) {
                    throw new \RuntimeException('Keranjang tidak ditemukan.');
                }

                $selectedItems = $cart->cartDetails()
                    ->whereIn('id', $selectedIds)
                    ->lockForUpdate()
                    ->get();

                if (
                    $selectedItems->isEmpty() ||
                    $selectedItems->count() !== count($selectedIds)
                ) {
                    throw new \RuntimeException('Produk checkout tidak valid.');
                }

                $total = 0;

                // Periksa stok terbaru sebelum membuat pesanan.
                foreach ($selectedItems as $item) {
                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$product || $product->stock < $item->quantity) {
                        throw new \RuntimeException('Stok produk tidak mencukupi.');
                    }

                    $total += $item->subtotal;
                }

                if ($orderForm['delivery_method'] === 'pickup') {
                    $shipping = 'Name: ' . $orderForm['name'] .
                        ', Phone: ' . $orderForm['phone'] .
                        ', Method: Pickup at Matcha Mori Store';
                } else {
                    $address = $this->normalizeAddress(
                            $orderForm['address']
                        );

                    $shipping = 'Name: ' . $orderForm['name'] .
                        ', Phone: ' . $orderForm['phone'] .
                        ', Address: ' . $address;
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'invoice' => $invoice ?? ('INV-' . strtoupper(Str::random(10))),
                    'shipping' => $shipping,
                    'payment_method' => $method,
                    'total' => $total,
                    'payment_status' => $paymentStatus,
                    'order_status' => 'Order Placed',
                    'latitude' => $orderForm['delivery_method'] === 'delivery'
                        ? ($orderForm['latitude'] ?? null)
                        : null,
                    'longitude' => $orderForm['delivery_method'] === 'delivery'
                        ? ($orderForm['longitude'] ?? null)
                        : null,
                ]);

                foreach ($selectedItems as $item) {
                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->subtotal,
                    ]);

                    $product->decrement('stock', $item->quantity);

                    $item->delete();
                }

                if ($createPayment) {
                    Payment::create([
                        'order_id' => $order->id,
                        'payment_method' => $method,
                        'total_bayar' => $total,
                        'bukti_pembayaran' => null,
                        'status' => 'Paid',
                    ]);
                }

                $cart->update([
                    'total' => $cart->cartDetails()->sum('subtotal'),
                ]);

                return $order;
            });

            // Hapus session setelah order berhasil dibuat.
            session()->forget([
                'checkout.order_form',
                'checkout.selected_items',
                'checkout.transaction_invoice',
            ]);

            return $order;

        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }


    public function placeOrder()
    {
        $orderForm = session('checkout.order_form');

        if (!$orderForm) {

            return redirect()->route('customer.checkout.index')->with('error', 'Please complete shipping information first.');

        }

        $method = $orderForm['payment_method'] ?? 'COD';

        if ($method !== 'COD') {
            return redirect()->route('customer.checkout.index');
        }

        $order = $this->createOrderFromCheckout(
            'COD',
            'Unpaid',
            false
        );

        if (!$order) {
            return redirect()->route('customer.checkout.index')->with('error', 'Checkout gagal. Silakan periksa kembali stok produk.');
        }

        return redirect()->route('customer.checkout.confirmation', $order->id)->with('success', 'Checkout successful!');
    }


    public function paymentResult($id)
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->whereIn('payment_method', ['DANA', 'GoPay', 'OVO'])
            ->findOrFail($id);

        // Tentukan metode penerimaan pesanan.
        $isPickup = str_contains(
            $order->shipping,
            'Method: Pickup at Matcha Mori Store'
        );

        // Ambil alamat dari informasi pengiriman.
        $address = '';

        if (!$isPickup && str_contains($order->shipping, ', Address: ')) {
            $address = Str::after($order->shipping, ', Address: ');
        }

        $orderForm = [
            'delivery_method' => $isPickup ? 'pickup' : 'delivery',
            'address' => $address,
        ];

        $selectedItems = $order->orderDetails;
        $subtotal = $order->total;
        $total = $order->total;
        $paymentMethod = $order->payment_method;
        $isWalletPayment = true;

        return view('customers.checkout.payment', compact(
            'order',
            'orderForm',
            'selectedItems',
            'subtotal',
            'total',
            'paymentMethod',
            'isWalletPayment'
        ));
    }

    
    public function confirmation($id)
    {
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customers.checkout.confirmation', compact('order'));
    }
}