<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merek;
use App\Models\Product;
use App\Models\Slider;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->input('title');
        $merek_id = $request->input('merek_id');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        $query = Product::query();

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
        if ($merek_id) {
            $query->where('merek_id', $merek_id);
        }
        if ($min_price) {
            $query->where('price', '>=', $min_price);
        }
        if ($max_price) {
            $query->where('price', '<=', $max_price);
        }

        $products = $query->latest()->paginate(10);
        $mereks = Merek::all();

        // Menambahkan slider
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();

        return view('user.index', compact('products', 'mereks', 'headerSliders', 'eventSliders'));
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('user.detail', compact('product'));
    }
}
