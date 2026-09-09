<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //menampilkan daftar produk (bisa difilter per kategori)
    public function index(Request $request)
    {
        $query = Product::with('category');
        //filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        //fitur cari produk berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('customers.products.index', compact('products', 'categories'));
    }

    //menampilkan detail satu produk
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);

        //menampilkan beberapa produk lain dari kategori yang sama
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->take(4)->get();

        return view('customers.products.show', compact('product', 'retaledProducts'));
    }
}
