<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::orderBy('urutan')->paginate(15);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'foto' => 'nullable|image|max:4096',
        ]);

        $data = $request->except(['_token', 'foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fasilitas', 'public');
        }

        Fasilitas::create($data);
        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'foto' => 'nullable|image|max:4096',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fasilitas', 'public');
        }

        $fasilitas->update($data);
        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Fasilitas $fasilitas)
    {
        $fasilitas->delete();
        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
