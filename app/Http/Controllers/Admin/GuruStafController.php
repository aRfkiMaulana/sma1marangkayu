<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruStaf;
use Illuminate\Http\Request;

class GuruStafController extends Controller
{
    public function index()
    {
        $guru = GuruStaf::where('tipe', 'guru')->orderBy('urutan')->paginate(15);
        $staf = GuruStaf::where('tipe', 'staf')->orderBy('urutan')->paginate(15, ['*'], 'staf_page');
        return view('admin.guru-staf.index', compact('guru', 'staf'));
    }

    public function create()
    {
        return view('admin.guru-staf.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:150',
            'tipe'  => 'required|in:guru,staf',
            'foto'  => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', 'foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru-staf', 'public');
        }

        GuruStaf::create($data);
        return redirect()->route('admin.guru-staf.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(GuruStaf $guruStaf)
    {
        return view('admin.guru-staf.edit', compact('guruStaf'));
    }

    public function update(Request $request, GuruStaf $guruStaf)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'tipe' => 'required|in:guru,staf',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru-staf', 'public');
        }

        $guruStaf->update($data);
        return redirect()->route('admin.guru-staf.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(GuruStaf $guruStaf)
    {
        $guruStaf->delete();
        return redirect()->route('admin.guru-staf.index')->with('success', 'Data berhasil dihapus.');
    }
}
