<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'judul'    => 'nullable|string|max:200',
            'subjudul' => 'nullable|string|max:255',
            'urutan'   => 'nullable|integer',
            'is_aktif' => 'nullable|boolean',
            'gambar'   => 'required|image|max:4096',
        ]);

        $data = $request->only(['judul', 'subjudul', 'urutan', 'is_aktif']);
        $data['gambar'] = ImageService::uploadWebp($request->file('gambar'), 'sliders');

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
            'judul'    => 'nullable|string|max:200',
            'subjudul' => 'nullable|string|max:255',
            'urutan'   => 'nullable|integer',
            'is_aktif' => 'nullable|boolean',
            'gambar'   => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['judul', 'subjudul', 'urutan', 'is_aktif']);

        if ($request->hasFile('gambar')) {
            if ($slider->gambar) {
                Storage::disk('public')->delete($slider->gambar);
            }
            $data['gambar'] = ImageService::uploadWebp($request->file('gambar'), 'sliders');
        }

        $slider->update($data);
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->gambar) {
            Storage::disk('public')->delete($slider->gambar);
        }

        $slider->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }
}
