<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'Order_id';
    protected $table = 'orders';
       protected $fillable = [
        'NO_Table',
        'status_table',
    ];
}
