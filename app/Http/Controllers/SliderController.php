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
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();

        return view('admin-feature.sliders.index', compact('headerSliders', 'eventSliders'));
    }

    public function showSliders()
    {
        $headerSliders = Slider::where('type', 'header')->get();
        $eventSliders = Slider::where('type', 'event')->get();
        return view('user.index', compact('headerSliders', 'eventSliders'));
    }

    public function create()
    {
        return view('admin-feature.sliders.create');
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
            ->with('success', 'Berhasil membuat slider');
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin-feature.sliders.edit', compact('slider'));
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
            if (File::exists(public_path('images/' . $slider->image))) {
                File::delete(public_path('images/' . $slider->image));
                Log::info('Deleted old image: ' . $slider->image);
            } else {
                Log::warning('Old image not found: ' . $slider->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $slider->image = $imageName;

            $slider->update([
                'title'   => $request->title,
                'image'   => $imageName,
                'type'    => $request->type,
            ]);
        } else {
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

        if (File::exists(public_path('images/' . $slider->image))) {
            File::delete(public_path('images/' . $slider->image));
        }

        $slider->delete();

        return redirect()->route('sliders.index')
            ->with('success', 'Slider berhasil dihapus');
    }
}
