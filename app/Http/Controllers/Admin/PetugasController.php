<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\BackupData;

class PetugasController extends Controller
{

public function index(Request $request)
{

$p = 'petugas';

$search = $request->search;

$petugas = User::where('role','petugas')
->when($search,function($query,$search){

$query->where(function($q) use ($search){

$q->where('name','like',"%$search%")
->orWhere('email','like',"%$search%");

});

})
->orderBy('id','desc')
->get();

return view('admin.petugas.index',compact('petugas','p'));

}


public function create()
{

$p = 'petugas';

return view('admin.petugas.tambah',compact('p'));

}


public function store(Request $request)
{

$request->validate([
'name'=>'required',
'email'=>'required|email|unique:users,email',
'password'=>'required|min:6'
]);

User::create([
'name'=>$request->name,
'email'=>$request->email,
'password'=>bcrypt($request->password),
'role'=>'petugas',
'status'=>'aktif'
]);

return redirect('/admin/petugas');

}


public function edit($id)
{

$p = 'petugas';

$petugas = User::findOrFail($id);

return view('admin.petugas.edit',compact('petugas','p'));

}


public function update(Request $request,$id)
{

$petugas = User::findOrFail($id);

$request->validate([
'name'=>'required',
'email'=>"required|email|unique:users,email,$id"
]);

$data=[
'name'=>$request->name,
'email'=>$request->email,
'status'=>$request->status
];

if($request->password){
$data['password']=bcrypt($request->password);
}

$petugas->update($data);

return redirect('/admin/petugas');

}


public function destroy($id)
{

$petugas = User::findOrFail($id);

BackupData::create([
'original_id'=>$petugas->id,
'table_name'=>'users',
'data_backup'=>json_encode($petugas->makeVisible('password')->toArray()),
'deleted_by'=>Auth::user()->name,
'deleted_at'=>now()
]);

$petugas->delete();

return redirect()->back();

}

}