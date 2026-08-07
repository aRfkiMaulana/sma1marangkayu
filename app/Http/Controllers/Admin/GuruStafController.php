<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruStaf;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'nama'       => 'required|string|max:150',
            'jabatan'    => 'nullable|string|max:150',
            'tipe'       => 'required|in:guru,staf',
            'urutan'     => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'foto'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'jabatan', 'tipe', 'urutan', 'keterangan']);

        if ($request->hasFile('foto')) {
            $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'guru-staf');
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
            'nama'       => 'required|string|max:150',
            'jabatan'    => 'nullable|string|max:150',
            'tipe'       => 'required|in:guru,staf',
            'urutan'     => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'foto'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'jabatan', 'tipe', 'urutan', 'keterangan']);

        if ($request->hasFile('foto')) {
            if ($guruStaf->foto) {
                Storage::disk('public')->delete($guruStaf->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru-staf', 'public');
        }

        $guruStaf->update($data);
        return redirect()->route('admin.guru-staf.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(GuruStaf $guruStaf)
    {
        if ($guruStaf->foto) {
            Storage::disk('public')->delete($guruStaf->foto);
        }

        $guruStaf->delete();
        return redirect()->route('admin.guru-staf.index')->with('success', 'Data berhasil dihapus.');
    }
}
