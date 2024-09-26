<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Order::with('user', 'items.product');

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereNotIn('status', ['completed', 'canceled']);
        } 
        $orders = $query->get();
        return view('admin-feature.order.index', compact('orders', 'status', 'query'));
    }

    public function show(string $id)
    {
        $orders = Order::with('items.product')->findOrFail($id);

        return view('admin-feature.order.show', compact('orders'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $orders = Order::findOrFail($id);
        if ($orders->status === 'completed') {
            return redirect()->route('order.index')->with(['error' => 'Order yang sudah berhasil tidak dapat diubah lagi!']);
        }
        if ($orders->status === 'canceled') {
            return redirect()->route('order.index')->with(['error'=> 'Order yang sudah di batalkan tidak bisa di ubah!']);
        }
        $orders->status = $request->input('status');
        $orders->save();

        return redirect()->route('order.index')->with(['success' => 'Status telah di update!']);
    }

    public function admincancelorder()
    {
        $cancelOrders = Order::where('status', 'canceled')->get();
        
        return view('admin-feature.order.cancel', compact('cancelOrders'));
    }

    public function admincompletedorder()
    {
        $completedOrders = Order::where('status', 'completed')->get();
        
        return view('admin-feature.order.completed', compact('completedOrders'));
    }
}
