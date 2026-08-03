<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;

class PesanController extends Controller
{
    public function index()
    {
        $pesan = Pesan::latest()->paginate(20);
        return view('admin.pesan.index', compact('pesan'));
    }

    public function show(Pesan $pesan)
    {
        $pesan->update(['is_read' => true]);
        return view('admin.pesan.show', compact('pesan'));
    }

    public function destroy(Pesan $pesan)
    {
        $pesan->delete();
        return redirect()->route('admin.pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
