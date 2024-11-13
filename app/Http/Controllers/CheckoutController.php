<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $qty = $request->input('qty', 1);
        $usercart = Cart::where('user_id', $user->id)->get();;
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = $response->json()['rajaongkir']['results'];

        foreach ($usercart as $cartItems) {
            if ($cartItems->qty <= 0) {
                return redirect()->back()->with(['error', 'Stok produk tidak mencukupi']);
            }
        }

        $totalWeight = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $totalWeight += $product->weight * $item->qty;
            }  
        }



        return view('user.checkout', [
            'user' => $user,
            'profile' => $profile,
            'cartItems' => $cartItems,
            'provinces' => $provinces,
            'totalWeight' => $totalWeight,
        ]);
    }
    public function store(Request $request, $product_idd)
    {

        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'addres' => 'required|string',
            'shipping_cost' => 'required|numeric',
        ]);

        $product_id = $request->input('product_id');

        $cartItems = [];

        if ($product_idd) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->where('product_id', $product_idd)
                ->get();
        } else {
            $cartItems = Cart::where('user_id', Auth::id())->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = 0;
        $totalWeight = 0; // Inisialisasi totalWeight
        $itemDetails = [];

        foreach ($cartItems as $item) {
            $product = $item->product;

            if (!$product) {
                continue; // Jika produk tidak ditemukan, lanjutkan
            }

            $total += $product->price * $item->qty;
            $totalWeight += $product->weight * $item->qty; // Hitung total berat

            // Item details untuk Midtrans
            $itemDetails[] = [
                'id' => $product->id,
                'price' => (int) $product->price,
                'quantity' => (int) $item->qty,
                'name' => $product->title ?: 'Produk Tanpa Nama',
            ];
        }

        $shippingCost = (float) $request->shipping_cost;

        // Item detail untuk ongkir
        $itemDetails[] = [
            'id' => 'ONGKIR',
            'price' => (int) $shippingCost,
            'quantity' => 1,
            'name' => 'Ongkos Kirim',
        ];

        // Hitung total biaya
        $totalCost = $total + $shippingCost;

        if ($total < 0.01) {
            return redirect()->back()->with('error', 'Jumlah total harus lebih besar atau sama dengan 0.01.');
        }

        // Simpan order
        $order = Order::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'addres' => $request->addres,
            'status' => 'pending',
            'total' => $totalCost,
            'user_id' => Auth::id(),
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->product->price,
            ]);
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Snap API
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $totalCost,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone ?? 'Tidak tersedia',
            ],
            'item_details' => $itemDetails,
            'shipping_address' => [
                'first_name' => Auth::user()->name,
                'address' => $request->addres ?? 'Lihat di Db Admin',
                'postal_code' => '12345',
                'phone' => Auth::user()->phone ?? 'Tidak tersedia',
                'country_code' => 'IDN',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
            // $product_id = 13;

            // Hapus item dari keranjang setelah checkout berhasil
            Cart::where('user_id', Auth::id())->where('product_id', $product_idd)->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }

        return redirect()->route('user.success')->with('order', $order);
    }


    public function checkoutFromProduct(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        // $cart = Cart::findOrFail($product_id);
        $user = Auth::user();
        $profile = $user->profile;
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/province');


        $provinces = $response->json()['rajaongkir']['results'];

        $qty = $request->input('qty', 1);

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product_id],
            ['qty' => $qty]
        );

        $totalWeight = $product->weight * $qty;

        $cartItems = Cart::where('user_id', Auth::id())->where('product_id', $product_id)->get();

        return view('user.checkout', [
            'product' => $product,
            'user' => $user,
            'profile' => $profile,
            'cartItems' => $cartItems,
            'provinces' => $provinces,
            'totalWeight' => $totalWeight,
            'single_product_checkout' => true
        ]);
    }

    public function success(Request $request)
    {
        $order =  session('order') ?? Order::where('user_id', Auth::id())->latest()->first();

        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Tidak ada order yang ditemukan.');
        }
        return view('user.success', compact('order'));
    }

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = $response->json()['rajaongkir']['results'];
        return view('user.checkout', ['provinces' => $provinces]);
    }

    // Mendapatkan daftar kota berdasarkan provinsi yang dipilih
    public function getCities($province_id)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get("https://api.rajaongkir.com/starter/city?province=" . $province_id);

        $cities = $response->json()['rajaongkir']['results'];
        return response()->json($cities);
    }

    public function getShippingCost(Request $request)
    {
        $destination = $request->input('destination');
        $weight = $request->input('weight'); // Berat produk

        // Asumsi Anda punya kota asal (warehouse)
        $origin = env('RAJAONGKIR_ORIGIN_CITY_ID'); // Kota asal (misal: Jakarta)

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => 'jne'
        ]);

        $shippingCost = $response->json()['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];

        return response()->json([
            'success' => true,
            'cost' => $shippingCost
        ]);
    }
}
