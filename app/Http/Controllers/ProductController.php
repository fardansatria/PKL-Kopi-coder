<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Merek;
use App\Models\ProductImage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $mereks = Merek::all(); // Get all mereks
        return view('products.create', compact('mereks'));
    }

    public function store(Request $request): RedirectResponse
    {
        //validasi form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'images.*'      => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'merek_id'      => 'required|exists:mereks,id'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        $product = Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'merek_id'      => $request->merek_id
        ]);

        // periksa image tambahan apakah di upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $file->storeAs('public/products', $file->hashName());

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->hashName()
                ]);
            }
        }

        //redirect ke index
        return redirect()->route('products.index')->with(['success' => 'Produk Berhasil Ditambahkan']);
    }


    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.detail', compact('product'));
    }

    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $mereks = Merek::all();
        return view('products.edit', compact('product', 'mereks'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'merek_id' => 'required|exists:mereks,id'
        ]);

        $product = Product::with('productImages')->findOrFail($id);

        // Update main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            if (Storage::exists('public/products/' . $product->image)) {
                // Delete old main image
                Storage::delete('public/products/' . $product->image);
                Log::info('Deleted old main image: ' . $product->image);
            } else {
                Log::warning('Old main image not found: ' . $product->image);
            }

            $product->image = $image->hashName();
        }

        // Update product details
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->merek_id = $request->merek_id;
        $product->save();

        // Update tambahan images
        if ($request->hasFile('images')) {
            
            foreach ($product->productImages as $productImage) {
                if (Storage::exists('public/products/' . $productImage->image)) {
                    // Delete old tambahan images
                    Storage::delete('public/products/' . $productImage->image);
                    Log::info('Deleted old additional image: ' . $productImage->image);
                } else {
                    Log::warning('Old additional image not found: ' . $productImage->image);
                }
                $productImage->delete();
            }

            // tambah image tambahan
            foreach ($request->file('images') as $file) {
                $file->storeAs('public/products', $file->hashName());

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->hashName()
                ]);
            }
        }

        return redirect()->route('products.index')->with(['success' => 'Produk Berhasil diupdate']);
    }


    public function destroy(string $id): RedirectResponse
    {
        $product = Product::with('productImages')->findOrFail($id);

        // Hapus main image
        Storage::delete('public/products/' . $product->image);

        // Hapus image tambahan
        if ($product->productImages) {
            foreach ($product->productImages as $image) {
                Storage::delete('public/products/' . $image->image);
                $image->delete();
            }
        }

        // Hapus produk
        $product->delete();

        return redirect()->route('products.index')->with(['success' => 'Produk Berhasil dihapus!']);
    }
}
