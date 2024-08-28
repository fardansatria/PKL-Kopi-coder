<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('user.checkout', [
            'user' => $user,
            'profile' => $profile,
            'cartItems' => $cartItems
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'addres' => 'required|string',
            'payment_method' => 'required|string|in:cod, bank-transfer',

        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->qty;
        }

        $order = Order::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'addres' => $request->addres,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'total' => $total,
            'user_id' => Auth::id(),
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->product->price,
            ]);
        }
        // Setelah order berhasil, hapus item dari keranjang
        Cart::where('user_id', Auth::id())->delete();

        if ($request->payment_method == 'bank-transfer') {
            return redirect()->route('user.success')->with([
                'order' => $order,
                'bankDetails' => [
                    'bank_name' => 'Bank ABC',
                    'bank_number' => '1234567890',
                    'bank_username' => 'Fardan Satria',
                ]
            ]);
        }
        return redirect()->route('user.success')->with('order', $order);
    }
    public function checkoutFromProduct(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $user = Auth::user();
        $profile = $user->profile;


        $qty = $request->input('qty', 1);


        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product_id],
            ['qty' => $qty]
        );


        $cartItems = Cart::where('user_id', Auth::id())->where('product_id', $product_id)->get();

        return view('user.checkout', [
            'product' => $product,
            'user' => $user,
            'profile' => $profile,
            'cartItems' => $cartItems
        ]);
    }

    public function success(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->latest()->first();

        if (!$order) {
            return redirect()->route('user.checkout')->with('error', 'Tidak ada order yang ditemukan.');
        }

        $bankDetails = $request->session()->get('payment_method');
        $bankDetails = null;

        if ($bankDetails == 'bank-transfer') {
            $bankDetails = [
                'bank_name' => 'Bank ABC',
                'bank_number' => '1234567890',
                'bank_username' => 'Fardan Satria',
            ];

            return redirect()->route('user.success', compact('order', 'bankDetails'));
        }
        return view('user.success', compact('order'));
    }
}
