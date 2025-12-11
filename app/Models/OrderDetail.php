<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'detail_order'; 
    protected $primaryKey = 'Detail_id';
    public $timestamps = true;

    protected $fillable = [
        'Order_id',
        'Menu_id',
        'Quantity',
        'Notes',
        'Price',
        'Sub_total'
    ];

  
    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_id', 'Order_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_id', 'Menu_id');
    }
}