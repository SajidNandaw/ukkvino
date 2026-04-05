<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BackupController extends Controller
{

    public function index()
    {

        $p = 'backup';

        // data yang belum direstore
        $backup = BackupData::whereNull('restored_at')
            ->orderBy('deleted_at','desc')
            ->get();

        // riwayat restore
        $history = BackupData::whereNotNull('restored_at')
            ->orderBy('restored_at','desc')
            ->get();

        return view('admin.backup.index',compact('backup','history','p'));
    }



    public function restore($id)
    {

        $data = BackupData::findOrFail($id);

        $table = $data->table_name;

        $backupData = json_decode($data->data_backup,true);


        if($backupData){

            /*
            |--------------------------------------------------------------------------
            | KHUSUS USER
            |--------------------------------------------------------------------------
            */

            if($table == 'users'){

                $user = DB::table('users')
                    ->where('email',$backupData['email'])
                    ->first();

                if($user){

                    DB::table('users')
                        ->where('id',$user->id)
                        ->update([
                            'deleted_at'=>null
                        ]);

                }else{

                    DB::table('users')->insert($backupData);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | KHUSUS PRODUK
            |--------------------------------------------------------------------------
            */

            elseif($table == 'produk'){

                $produk = DB::table('produk')
                    ->where('id',$backupData['id'])
                    ->first();

                if($produk){

                    DB::table('produk')
                        ->where('id',$produk->id)
                        ->update([
                            'deleted_at'=>null
                        ]);

                }else{

                    DB::table('produk')->insert($backupData);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | DEFAULT (TABEL LAIN)
            |--------------------------------------------------------------------------
            */

            else{

                $exists = DB::table($table)
                    ->where('id',$backupData['id'])
                    ->exists();

                if(!$exists){
                    DB::table($table)->insert($backupData);
                }

            }


            $data->update([
                'restored_at'=>now()
            ]);

        }


        return redirect()->route('admin.backup');

    }



    public function download($id)
    {

        $data = BackupData::findOrFail($id);

        $filename = "backup_".$data->table_name."_".now()->format('Ymd_His').".txt";

        return response($data->data_backup)
            ->header('Content-Type','text/plain')
            ->header('Content-Disposition',"attachment; filename=$filename");

    }

}