<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MerekController extends Controller
{
    public function index(): View
    {
        // Get all mereks with pagination
        $mereks = Merek::latest()->paginate(10);

        // Render view with mereks
        return view('admin-feature.merek.index', compact('mereks'));
    }

    public function create(): View
    {
        return view('admin-feature.merek.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate form
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'name'  => 'required',
            'slug'  => 'required'
        ]);

        // Upload image
        $image = $request->file('image');
        $imagePath = $image->storeAs('public/mereks', $image->hashName());

        // Create merek
        Merek::create([
            'image' => $image->hashName(),
            'name'  => $request->name,
            'slug'  => $request->slug,
        ]);

        // Redirect to index
        return redirect()->route('merek.index')->with('success', 'Merek Berhasil Ditambahkan');
    }

    public function edit(string $id): View
    {
        $merek = Merek::findOrFail($id);
        return view('admin-feature.merek.edit', compact('merek'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        // Validate form
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'name'  => 'required',
            'slug'  => 'required'
        ]);

        $merek = Merek::findOrFail($id);

        // Update merek
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newImageName = $image->hashName();
            $image->storeAs('public/mereks', $newImageName);

            // Delete old image
            if (Storage::exists('public/mereks/' . $merek->image)) {
                Storage::delete('public/mereks/' . $merek->image);
                Log::info('Deleted old image: ' . $merek->image);
            } else {
                Log::warning('Old image not found: ' . $merek->image);
            }

            // Update merek with new image
            $merek->update([
                'image' => $newImageName,
                'name'  => $request->name,
                'slug'  => $request->slug
            ]);
        } else {
            // Update merek without image
            $merek->update([
                'name' => $request->name,
                'slug' => $request->slug
            ]);
        }

        return redirect()->route('merek.index')->with('success', 'Merek Berhasil Diupdate!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $merek = Merek::findOrFail($id);

        // Delete image
        if (Storage::exists('public/mereks/' . $merek->image)) {
            Storage::delete('public/mereks/' . $merek->image);
        }

        // Delete merek
        $merek->delete();

        return redirect()->route('merek.index')->with('success', 'Merek Berhasil Dihapus!');
    }
}
