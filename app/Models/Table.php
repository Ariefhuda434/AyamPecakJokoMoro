<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'No_Table';
    protected $table = 'tables';
    protected $fillable = [
        'NO_Table',
        'status_table',
    ];
}
