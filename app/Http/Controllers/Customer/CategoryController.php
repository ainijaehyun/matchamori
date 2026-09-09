<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //mennampilkan semua kategori
    public function index()
    {
        $categories = Category::latest()->get();

        return view('customers.categories.index', compact('categories'));
    }
}
