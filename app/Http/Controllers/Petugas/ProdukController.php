<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\File;
use App\Models\BackupData;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{

public function index(Request $request)
{

$p = 'produk';

$search = $request->search;

if($search){

$produk = Produk::where('nama','like',"%$search%")
->orWhere('deskripsi','like',"%$search%")
->orderBy('id','desc')
->get();

}else{

$produk = Produk::orderBy('id','desc')->get();

}

return view('petugas.produk.index',compact('produk','p'));

}


public function create() 
{

 return view('petugas.produk.tambah');

}


public function store(Request $request)
{

$data = $request->only([
'nama',
'deskripsi',
'harga',
'stok'
]);

if($request->hasFile('gambar')){

$gambar = time().'.'.$request->gambar->extension();
$request->gambar->move(public_path('uploads'),$gambar);
$data['gambar'] = $gambar;

}

Produk::create($data);

return redirect('/petugas/produk');

}


public function edit($id)
{

$p = 'produk';

$produk = Produk::findOrFail($id);

return view('petugas.produk.edit',compact('produk','p'));

}


public function update(Request $request,$id)
{

$produk = Produk::findOrFail($id);

$data = $request->only([
'nama',
'deskripsi',
'harga',
'stok'
]);

if($request->hasFile('gambar')){

if($produk->gambar && File::exists(public_path('uploads/'.$produk->gambar))){
File::delete(public_path('uploads/'.$produk->gambar));
}

$gambar = time().'.'.$request->gambar->extension();
$request->gambar->move(public_path('uploads'),$gambar);

$data['gambar'] = $gambar;

}

$produk->update($data);

return redirect('/petugas/produk');

}


public function destroy($id)
{

$produk = Produk::findOrFail($id);

BackupData::create([
'original_id'=>$produk->id,
'table_name'=>'produk',
'data_backup'=>json_encode($produk->toArray()),
'deleted_by'=>Auth::user()->name,
'deleted_at'=>now()
]);

$produk->delete();

return redirect('/petugas/produk')->with('success','Produk berhasil dihapus');

}

}