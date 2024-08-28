<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin-feature.order.index', compact('orders'));
    }

    public function show(string $id)
    {
        $orders = Order::with('items.product')->findOrFail($id);

        return view('admin-feature.order.show', compact('orders'));
    }
}