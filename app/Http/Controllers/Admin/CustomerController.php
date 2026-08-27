<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //menampilkan daftar semua customer
    public function index()
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    //menampilkan detail satu customer
    public function show(string $id)
    {
        $customer = User::where('role', 'customer')->with('orders')->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }
}
