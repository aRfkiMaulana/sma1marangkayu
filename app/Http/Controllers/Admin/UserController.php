<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            $u = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => 'admin',
                'password' => Hash::make($request->password),
            ]);

            ActivityLog::log('create', 'Pengelola CMS', "Menambahkan pengelola CMS baru: {$u->name} ({$u->email})");

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Pengelola CMS berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan pengelola: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'name'  => $request->name,
                'email' => $request->email,
                'role'  => 'admin',
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            ActivityLog::log('update', 'Pengelola CMS', "Mengubah data pengelola: {$user->name}");

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Data pengelola CMS berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui pengelola: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            DB::beginTransaction();

            $name = $user->name;
            $user->delete();
            ActivityLog::log('delete', 'Pengelola CMS', "Menghapus pengelola CMS: {$name}");

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Pengelola CMS berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus pengelola: ' . $e->getMessage());
        }
    }
}
