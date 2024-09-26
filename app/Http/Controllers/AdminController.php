<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\merek;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;


class AdminController extends Controller
{
    public function search(Request $request): View
    {
        $search = $request->input('search');

        // Query untuk mencari produk
        $products = Product::where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();

        // Query untuk mencari merek
        $mereks = Merek::where('name', 'like', '%' . $search . '%')
            ->get();

        return view('admin-feature.search-result', compact('products', 'mereks'));
    }

    public function print_pdf($id)
    {
        $data = Order::with('items')->find($id);

        if (!$data) {
            abort(404, 'Order not found');
        }
        $pdf = Pdf::loadView('admin-feature.invoice', compact('data'));
        return $pdf->download('invoice.pdf');
    }

    public function soldProducts()
    {
        $product = Product::where('sold', '>', 0)->orderBy('sold', 'desc')->get();
        return view('admin-feature.products.sold', compact('product'));
    }
}
