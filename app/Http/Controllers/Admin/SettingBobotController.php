<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SettingBobotPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingBobotController extends Controller
{
    public function index()
    {
        $bobotList = SettingBobotPrestasi::all();
        return view('admin.setting-bobot.index', compact('bobotList'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bobot'   => 'required|array',
            'bobot.*' => 'required|integer|min:0|max:1000',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->bobot as $tingkat => $bobotVal) {
                SettingBobotPrestasi::where('tingkat', $tingkat)->update(['bobot' => $bobotVal]);
            }

            ActivityLog::log('update', 'Pengaturan Bobot Poin', "Memperbarui bobot poin prestasi ekstrakurikuler.");

            DB::commit();
            return redirect()->back()->with('success', 'Bobot poin prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui bobot: ' . $e->getMessage());
        }
    }
}
