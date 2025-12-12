<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class RestockLog extends Model
{
    protected $table = 'restock_log';

    protected $primaryKey = 'Restock_id';

    // public $timestamps = false;
    
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
    protected function jumlahSetelah(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 
                $attributes['Stock_Before'] + $attributes['Update_Quantity'],
        );
    }
}
