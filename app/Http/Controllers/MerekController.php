<?php

namespace App\Http\Controllers;

//import model Merek
use App\Models\Merek;

//import return type View
use Illuminate\View\View;

//import return type RedirectResponse
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Log;

//import Http Request
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class MerekController extends Controller
{
   
    public function index(): View
    {
        //get all mereks
        $mereks = Merek::latest()->paginate(10);

        //render view with mereks
        return view('merek.index', compact('mereks'));
    }

    public function create(): View
    {
        return view('merek.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'name'  => 'required',
            'slug'  => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/mereks', $image->hashName());

        //create merek
        Merek::create([
            'image' => $image->hashName(),
            'name'  => $request->name,
            'slug'  => $request->slug,
        ]);

        //redirect to index
        return redirect()->route('merek.index')->with(['success' => 'Merek Berhasil Ditambahkan']);
    }
    public function edit(string $id): View
    {
        $merek = Merek::findOrFail($id);
        return view('merek.edit', compact('merek'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'name'  => 'required',
            'slug'  => 'required'
        ]);

        $merek = Merek::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/mereks', $image->hashName());
            

            if (Storage::exists('public/mereks/' . $merek->image)) {
                // Delete old image
                Storage::delete('public/mereks/' . $merek->image);
                Log::info('Deleted old image: ' . $merek->image);
            } else {
                Log::warning('Old image not found: ' . $merek->image);
            }

            //update merek with new image
            $merek->update([
                'image' => $image->hashName(),
                'name'  => $request->name,
                'slug'  => $request->slug
            ]);
        } else {
            //update merek without image
            $merek->update([
                'name' => $request->name,
                'slug' => $request->slug
            ]);
        }

        return redirect()->route('merek.index')->with(['success' => 'Merek Berhasil Diupdate!']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $merek = Merek::findOrFail($id);
        
        //delete image
        Storage::delete('public/mereks/' . $merek->image);
        
        //delete merek
        $merek->delete();

        return redirect()->route('merek.index')->with(['success' => 'Merek Berhasil Dihapus!']);
    }
}
