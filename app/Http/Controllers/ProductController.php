<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\merek;
use App\Models\ProductImage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::latest(); // Memulai query untuk produk

        // Memeriksa apakah ada filter merek
        if ($request->has('merek_id') && $request->merek_id != '') {
            $query->where('merek_id', $request->merek_id); // Menambahkan kondisi filter
        }

        $products = $query->paginate(10); // Melakukan paginasi
        $mereks = Merek::all(); // Mengambil semua merek untuk dropdown
        return view('admin-feature.products.index', compact('products', 'mereks'));
    }

    public function create(): View
    {
        $mereks = Merek::all(); // Get all mereks
        return view('admin-feature.products.create', compact('mereks'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi form
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'merek_id' => 'required|exists:mereks,id',
            'weight' => 'required|numeric',
        ]);

        // Upload dan Resize gambar utama
        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('public/products', $imageName);

        $resizeSuccess = ImageHelper::resizeImage(
            storage_path('app/public/products/' . $imageName),
            storage_path('app/public/products/resized_' . $imageName),
            200,
            200
        );

        storage::delete('public/products/' . $imageName);

        if (!$resizeSuccess) {
            Log::error('Failed to resize main image: ' . $imageName);
            return redirect()->back()->withErrors(['error' => 'Gagal meresize gambar utama.']);
        }

        // Simpan data produk
        $product = Product::create([
            'image' => 'resized_' . $imageName,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'merek_id' => $request->merek_id,
            'weight' => $request->weight,
        ]);

        // Proses gambar tambahan
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = $file->hashName();
                $file->storeAs('public/products', $fileName);

                $resizeSuccess = ImageHelper::resizeImage(
                    storage_path('app/public/products/' . $fileName),
                    storage_path('app/public/products/resized_' . $fileName),
                    200,
                    200
                );

                Storage::delete('public/products/' . $fileName);

                if (!$resizeSuccess) {
                    Log::error('Failed to resize additional image: ' . $fileName);
                    return redirect()->back()->withErrors(['error' => 'Gagal meresize gambar tambahan.']);
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'resized_' . $fileName
                ]);
            }
        }

        return redirect()->route('products.index')->with(['success' => 'Produk Berhasil Ditambahkan']);
    }



    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('admin-feature.products.detail', compact('product'));
    }

    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $mereks = Merek::all();
        return view('admin-feature.products.edit', compact('product', 'mereks'));
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
            'merek_id' => 'required|exists:mereks,id',
            'weight' => 'required|numeric',
        ]);

        $product = Product::with('productImages')->findOrFail($id);

        // Update gambar utama jika ada
        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $newImageName = $newImage->hashName();
            $newImage->storeAs('public/products', $newImageName);

            $resizeSuccess = ImageHelper::resizeImage(
                storage_path('app/public/products/' . $newImageName),
                storage_path('app/public/products/resized_' . $newImageName),
                200,
                200
            );

            Storage::delete('public/products/' . $newImageName);

            if (!$resizeSuccess) {
                Log::error('Failed to resize main image: ' . $newImageName);
                return redirect()->back()->withErrors(['error' => 'Gagal meresize gambar utama.']);
            }

            // Hapus gambar utama lama
            if ($product->image && Storage::exists('public/products/' . $product->image)) {
                Storage::delete('public/products/' . $product->image);
                Log::info('Deleted old main image: ' . $product->image);
            }

            $product->image = 'resized_' . $newImageName;
        }

        // Update detail produk
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->merek_id = $request->merek_id;
        $product->weight = $request->weight;
        $product->save();

        // Update gambar tambahan
        if ($request->hasFile('images')) {
            // Hapus gambar tambahan lama
            foreach ($product->productImages as $productImage) {
                if (Storage::exists('public/products/' . $productImage->image)) {
                    Storage::delete('public/products/' . $productImage->image);
                    Log::info('Deleted old additional image: ' . $productImage->image);
                }
                $productImage->delete();
            }

            // Simpan gambar tambahan baru
            foreach ($request->file('images') as $file) {
                $fileName = $file->hashName();
                $file->storeAs('public/products', $fileName);

                $resizeSuccess = ImageHelper::resizeImage(
                    storage_path('app/public/products/' . $fileName),
                    storage_path('app/public/products/resized_' . $fileName),
                    200,
                    200
                );

                // Hapus gambar asli setelah resize
                Storage::delete('public/products/' . $fileName);

                if (!$resizeSuccess) {
                    Log::error('Failed to resize additional image: ' . $fileName);
                    return redirect()->back()->withErrors(['error' => 'Gagal meresize gambar tambahan.']);
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'resized_'  . $fileName
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
