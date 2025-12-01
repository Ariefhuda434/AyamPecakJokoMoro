<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestockLog extends Model
{
    protected $table = 'restock_log';

    protected $primaryKey = 'Restock_id';

    public $timestamps = false;

    protected $fillable = [
        'Stock_id',
        'Stock_Before',
        'Update_Quantity',
        'unit',
        'Price',
        'Date_in'
    ];
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'Stock_id', 'Stock_id');
    }
}
