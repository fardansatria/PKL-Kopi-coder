<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use App\Models\merek;
use Illuminate\Support\Facades\Mail;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin-feature.adminpage.index');
    }

    public function home()
    {
        $products = Product::limit(12)->get();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();
        $mereks = Merek::latest()->paginate(10);
        return view('user.index', compact('products', 'headerSliders', 'eventSliders', 'count', 'mereks'));
    }
    public function home_login()
    {
        $products = Product::limit(12)->get();
        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id', $userid)->count();
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();
        $mereks = Merek::latest()->paginate(10);
        return view('user.index', compact('products', 'headerSliders', 'eventSliders', 'count', 'mereks'));
    }

    public function product_detail($id)
    {
        $product = Product::with('ProductImages')->find($id);

        $otherProducts = Product::where('id', '!=', $id)->take(5)->get();

        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('user.product_detail', compact('product', 'count', 'otherProducts'));
    }
    public function add_cart(Request $request, $id)
    {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $qty = $request->input('qty', 1);

    
        $product = Product::find($product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($qty > $product->stock) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $existingCart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($existingCart) {
            $newQty = $existingCart->qty + $qty;
            if ($newQty > $product->stock) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }
            $existingCart->qty = $newQty;
            $existingCart->save();
        } else {
            $data = new Cart;
            $data->user_id = $user_id;
            $data->product_id = $product_id;
            $data->qty = $qty;
            $data->save();
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function mycart()
{
    if (Auth::id()) {
        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id', $userid)->count();
        $cart = Cart::where('user_id', $userid)->get();

        // Hitung total berat
        $totalWeight = 0;
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $totalWeight += $product->weight * $item->qty; // Menghitung total berat
            }
        }
    } else {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    return view('user.mycart', compact('count', 'cart', 'totalWeight'));
}


    public function cart_delete($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart) {
            $cart->delete();
            return redirect('mycart')->with('success', 'produk berhasil di hapus ');
        } else {
            return redirect('mycart')->with('error', 'produk tidak di temukan');
        }
    }

    public function userOrder(Request $request)
    {
        $status = $request->input('status');
        $count = '';

        $query = Order::with('user', 'items.product');

        if ($status) {
            $query->where('status', $status);
        }
        $orders = $query->get();
        return view('user.order', compact('orders', 'count', 'status', 'query'));
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = Order::find($id);

        $request->validate([
            'cancel_product' => 'required|string|max:225',
        ]);

        if ($order && $order->status == 'pending') {
            $order->status = 'canceled';
            $order->cancel_product = $request->cancel_product;
            $order->save();

            Mail::to($order->user->email)->send(new \App\Mail\OrderCanceledMail($order));

            return redirect()->back()->with(['success', 'Pesanan berhasil dibatalkan.']);
        }

        return redirect()->back()->with(['error', 'Pesanan tidak dapat dibatalkan.']);
    }



    public function user_search(Request $request)
    {
        $query = $request->input('query');
        $count = '';
        $sort = $request->input('sort');

        // query produk
        $productsQuery = Product::query();


        if ($query) {
            $productsQuery->where('title', 'LIKE', "%$query%");
        }

        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    $productsQuery->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $productsQuery->orderBy('price', 'desc');
                    break;
                case 'best_selling':
                    $productsQuery->orderBy('sold', 'desc');
                    break;
            }
        }

        // Ambil hasil query
        $products = $productsQuery->get();
        return view('user.search-result', compact('products', 'count'));
    }

    public function filterByBrand($slug)
    {
        $merek = Merek::where('slug', $slug)->firstOrFail();
        $products = Product::where('merek_id', $merek->id)->get();
        $count = '';

        return view('user.search-merek', compact('products', 'merek', 'count'));
    }
}
