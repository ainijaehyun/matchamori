<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sort By
        switch ($request->sort) {

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'name':
                $query->orderBy('name', 'asc');
                break;

            default:
                $query->latest();
                break;
        }

        // Pagination
        $products = $query->paginate(12)->withQueryString();

        // Semua kategori untuk Filter
        $categories = Category::orderBy('name')->get();

        return view('customers.products.index', compact('products', 'categories'));
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->take(4)->get();

        return view('customers.products.show', compact('product', 'relatedProducts'));
    }
}