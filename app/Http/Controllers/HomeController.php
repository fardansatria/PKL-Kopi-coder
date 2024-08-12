<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin-feature.adminpage.index');
    }

    public function home()
    {
        $products = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();
        return view('user.index', compact('products', 'headerSliders', 'eventSliders', 'count'));
    }
    public function home_login()
    {
        $products = Product::all();
        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id', $userid)->count();
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();
        return view('user.index', compact('products', 'headerSliders', 'eventSliders', 'count'));
    }

    public function product_detail($id)
    {
        $data = Product::find($id);
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('user.product_detail', compact('data', 'count'));
    }
    public function add_cart($id)
    {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $data->save();

        return redirect()->back()->with(['success' => 'Produk Berhasil ditambahkan ke keranjang!']);
    }

    public function mycart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();
        }
        return view('user.mycart', compact('count', 'cart'));
    }

    public function confirm_order(Request $request)
    {
        $name = $request->name;
        $addres = $request->addres;
        $phone = $request->phone;

        $userid = Auth::user()->id;
        $cart = Cart::where('user_id', $userid)->get();

        foreach($cart as $carts)
        {
            $order = new Order;

            $order->name = $name;
            $order->addres = $addres;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $carts->product_id;
            $order->save();

        }
        return redirect()->back();
    }
}
