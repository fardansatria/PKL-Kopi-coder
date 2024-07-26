<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin-feature.adminpage.index');
    }

    public function home()
    {
        $products = Product::all();
        return view('user.index', compact('products'));
    }
    public function home_login()
    {
        $products = Product::all();
        return view('user.index', compact('products'));
    }
}
