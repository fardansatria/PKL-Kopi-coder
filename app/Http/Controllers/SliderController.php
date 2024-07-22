<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $headerSliders = Slider::where('type', 'header')->Get();
        $eventSliders = Slider::where('type', 'event')->Get();

        return view('sliders.index', compact('headerSliders', 'eventSliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' =>   'required|string|max:255',
            'image' =>   'required|image|mimes:jpeg,jpg,png|max:2048',
            'type'  =>   'required|in:header,event',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Slider::create([
            'title'  => $request->title,
            'image'  => $imageName,
            'type'  => $request->type,
        ]);

        return redirect()->route('sliders.index')
            ->with('succes', 'Berhasil membuat slider');
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' =>   'required|string|max:255',
            'image' =>   'required|image|mimes:jpeg,jpg,png|max:2048',
            'type'  =>   'required|in:header,event',
        ]);

        $slider = Slider::findOrFail($id);
        if ($request->hasFile('image')) {

            if (file::exists(public_path('images/' . $slider->image))) {
                file::delete(public_path('images/' . $slider->image));
                Log::info('Deleted old image: ' . $slider->image);
            } else {
                Log::warning('Old image not found: ' . $slider->image);
            }

           
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $slider->image =$imageName;

            $slider->update([
                'title'   => $request->title,
                'image'   => $imageName,
                'type'    => $request->type,
            ]);
        }
        else {
            $slider->update([
                'title'   => $request->title,
                'type'    => $request->type,
            ]);
        }
        return redirect()->route('sliders.index')
        ->with('success', 'Slider berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

           if (file::exists(public_path('images/'. $slider->image))) {
               file::delete(public_path('images/' . $slider->image));
           }

            $slider->delete();

        return redirect()->route('sliders.index')
        ->with('success', 'Slider berhasil di hapus');
    }
}
