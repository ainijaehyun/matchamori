<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
Use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Auth; 

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();

        return view('customer.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        //cari/buat cart milik user sendiri
        $cart = Cart::firstOrCreate(
            ['user-_id' => Auth::id()],
            ['total' => 0]
        );

        //cek apakah product ini sudah ada dicart
        $detail = CartDetail::where('cart_id', $cart->id)->where('product_id', $product->id)->first();

        if ($detail) {
            //sudah ada
            $detail->quantity += $validated['quantity'];
            $detail->subtotal = $detail->quantity * $detail->price;
            $detail->save();
        } else {
            //belum ada
            CartDetail::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $validated['quantity'],
            ]);
        }

         //hitung ulang total cart
        $this->recalculateTotal($cart);

        return redirect()->route('customer.cart.index')->with('success', 'Product successfully added to cart.');

    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $detail = CartDetail::findOrFail($id);

        //pastikan cart detail ini benar benar punya mliki user yang login
        if ($detail->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $detail->quantity = $validated['quantity'];
        $detail->subtotal = $detail->quantity * $detail->price;
        $detail->save();

        $this->recalculateTotal($detail->cart);

        return redirect()->route('customer.cart.index')
            ->with('success', 'Cart Updated Successfully.');
    }

    public function destroy(string $id)
    {
        $detail = CartDetail::findOrFail($id);
        
        if ($detail->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart = $detail->cart;
        $detail->delete();

        return redirect()->route('customer.cart.index')->with('success', 'Product Deleted Succesfully from Cart.');
    }

    private function recalculateTotal(Cart $cart)
    {
        $cart->total = $cart->cartDetails()->sum('subtotal');
        $cart->save();
    }
}
