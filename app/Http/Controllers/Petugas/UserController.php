<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::where('role','user')
        ->when($search,function($query,$search){
            return $query->where(function($q) use ($search){
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%");
            });
        })
        ->orderBy('id','desc')
        ->get();

        return view('petugas.user.index',compact('users','search'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('petugas.user.edit',compact('user'));
    }


    public function update(Request $request,$id)
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

        return redirect()->route('user.index')
        ->with('success','User berhasil diupdate');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $dataBackup = $user->toArray();

        DB::table('backup_data')->insert([
            'original_id' => $user->id,
            'table_name' => 'users',
            'data_backup' => json_encode($dataBackup),
            'deleted_by' => Auth::check() ? Auth::user()->id : null,
            'deleted_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->delete();

        return redirect()->back()
        ->with('success','User berhasil dihapus dan dibackup');
    }

}