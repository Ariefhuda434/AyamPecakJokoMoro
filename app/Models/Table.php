<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'No_Table';
    protected $table = 'tables';
    protected $fillable = [
        'NO_Table',
        'status_table',
    ];
public function activeOrder()
{
    return $this->hasOne(Order::class, 'No_Table', 'No_Table')
                ->where('Order_Status', 'Belum_Bayar');
}
public function activeCustomer()
{
    return $this->hasOneThrough(
        Customer::class,
        Order::class,
        'No_Table', 
        'Customer_id', 
        'Customer_id' 
    )->where('orders.Order_Status', 'Belum_Bayar'); 
}
}
