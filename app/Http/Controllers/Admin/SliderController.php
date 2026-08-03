<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('urutan')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'   => 'nullable|string|max:200',
            'gambar'  => 'required|image|max:4096',
        ]);

        $data = $request->except(['_token', 'gambar']);
        $data['gambar'] = $request->file('gambar')->store('sliders', 'public');

        Slider::create($data);
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'judul'  => 'nullable|string|max:200',
            'gambar' => 'nullable|image|max:4096',
        ]);

        $data = $request->except(['_token', '_method', 'gambar']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('sliders', 'public');
        }

        $slider->update($data);
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }
}
