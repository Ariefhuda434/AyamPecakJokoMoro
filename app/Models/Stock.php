<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $primaryKey = 'Stock_id';

    public $timestamps = false;

    protected $fillable = [
        'Name_Stock',
        'Unit',
        'Current_Stock',
        'Min_Stock_Level',
        'Last_Cost',
        'Last_Updated'
    ];
}
