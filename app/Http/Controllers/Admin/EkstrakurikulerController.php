<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ekstrakurikuler;
use App\Models\EkskulPersonel;
use App\Services\HtmlSanitizer;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikuler = Ekstrakurikuler::withCount('personel')->latest()->paginate(15);
        return view('admin.ekstrakurikuler.index', compact('ekstrakurikuler'));
    }

    public function create()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string|max:150',
            'deskripsi'         => 'nullable|string',
            'pembina'           => 'nullable|string|max:150',
            'jadwal'            => 'nullable|string|max:255',
            'foto'              => 'nullable|image|max:4096',
            'personel.*.nama'   => 'nullable|string|max:150',
            'personel.*.jabatan'=> 'nullable|string|max:150',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'pembina', 'jadwal']);
        $data['deskripsi'] = HtmlSanitizer::clean($data['deskripsi'] ?? null);
        $data['is_aktif']  = $request->boolean('is_aktif');

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'ekstrakurikuler');
            }

            $ekskul = Ekstrakurikuler::create($data);

            foreach ($request->input('personel', []) as $i => $p) {
                if (!empty($p['nama'])) {
                    $ekskul->personel()->create([
                        'nama'    => $p['nama'],
                        'jabatan' => $p['jabatan'] ?? null,
                        'urutan'  => $i,
                    ]);
                }
            }

            ActivityLog::log('create', 'Ekstrakurikuler', "Menambahkan ekstrakurikuler: {$ekskul->nama}");

            DB::commit();
            return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->load('personel');
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $request->validate([
            'nama'              => 'required|string|max:150',
            'deskripsi'         => 'nullable|string',
            'pembina'           => 'nullable|string|max:150',
            'jadwal'            => 'nullable|string|max:255',
            'foto'              => 'nullable|image|max:4096',
            'personel.*.nama'   => 'nullable|string|max:150',
            'personel.*.jabatan'=> 'nullable|string|max:150',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'pembina', 'jadwal']);
        $data['deskripsi'] = HtmlSanitizer::clean($data['deskripsi'] ?? null);
        $data['is_aktif']  = $request->boolean('is_aktif');
        $oldFoto = $ekstrakurikuler->foto;

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'ekstrakurikuler');
            }

            $ekstrakurikuler->update($data);

            $ekstrakurikuler->personel()->delete();
            foreach ($request->input('personel', []) as $i => $p) {
                if (!empty($p['nama'])) {
                    $ekstrakurikuler->personel()->create([
                        'nama'    => $p['nama'],
                        'jabatan' => $p['jabatan'] ?? null,
                        'urutan'  => $i,
                    ]);
                }
            }

            if ($oldFoto && $request->hasFile('foto')) {
                Storage::disk('public')->delete($oldFoto);
            }

            ActivityLog::log('update', 'Ekstrakurikuler', "Mengubah ekstrakurikuler: {$ekstrakurikuler->nama}");

            DB::commit();
            return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['foto']) && $request->hasFile('foto')) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        try {
            DB::beginTransaction();

            $nama = $ekstrakurikuler->nama;
            $foto = $ekstrakurikuler->foto;

            $ekstrakurikuler->delete();

            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            ActivityLog::log('delete', 'Ekstrakurikuler', "Menghapus ekstrakurikuler: {$nama}");

            DB::commit();
            return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
