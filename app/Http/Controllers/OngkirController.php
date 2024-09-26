<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OngkirController extends Controller
{
    public function ongkir() 
    {
        $response = Http::withUrlParameters([
            'key' => 'c21e4ec8405998fad78b5d28437d592c'
        ])->get('https://api.rajaongkir.com/starter/city');

        dd($response);

        return view('user.checkout');
    }
}
