<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupData extends Model
{
    protected $table = 'backup_data';

    protected $fillable = [
        'table_name',
        'data_backup',
        'deleted_at',
        'restored_at'
    ];
}