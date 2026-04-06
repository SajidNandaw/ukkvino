<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Halaman daftar user
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::where('role','user')
            ->when($search, function($query, $search){
                return $query->where(function($q) use ($search){
                    $q->where('name','like',"%$search%")
                      ->orWhere('email','like',"%$search%");
                });
            })
            ->orderBy('id','desc')
            ->get();

        return view('petugas.user.index', compact('users','search'));
    }

    // Halaman edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('petugas.user.edit', compact('user'));
    }

    // Proses update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'status' => 'required'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status
        ]);

        return redirect()->route('petugas.user.index')
                         ->with('success', 'User berhasil diupdate');
    }

    // Hapus user dan backup data
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::table('backup_data')->insert([
            'original_id' => $user->id,
            'table_name' => 'users',
            'data_backup' => json_encode($user->toArray()),
            'deleted_by' => Auth::check() ? Auth::user()->id : null,
            'deleted_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->delete();

        return redirect()->back()
            ->with('success', 'User berhasil dihapus dan dibackup');
    }

    // Nonaktifkan user
    public function nonaktif($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'nonaktif';
        $user->save();

        return redirect()->back()->with('success', 'User berhasil dinonaktifkan');
    }

    // Aktifkan user
    public function aktifkan($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diaktifkan');
    }
}