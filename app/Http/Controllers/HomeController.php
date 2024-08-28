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
    public function add_cart(Request $request, $id)
    {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $qty = $request->input('qty', 1);

        $existingCart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($existingCart) {
            
            $existingCart->qty += $qty;
            $existingCart->save();
        } else {
            
            $data = new Cart;
            $data->user_id = $user_id;
            $data->product_id = $product_id;
            $data->qty = $qty;
            $data->save();
        }

        return redirect()->back()->with('success', 'Produk Berhasil ditambahkan ke keranjang!');
    }

    public function mycart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $value = 0;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();

           
        }
        return view('user.mycart', compact('count', 'cart'));
    }

    public function cart_delete($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart) {
            $cart->delete();
            return redirect('mycart')->with( 'success' , 'produk berhasil di hapus ');
        } else {
            return redirect('mycart')->with( 'error' , 'produk tidak di temukan');
        }
    }

}