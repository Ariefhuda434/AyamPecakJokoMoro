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
  return $this->hasOne(Order::class,'No_Table','No_Table')
                ->whereNotIn('Order_Status', ['Selesai', 'Batal']) 
                ->latestOfMany('Order_id');
}
public function activeCustomer()
{
   return $this->hasOne(Customer::class, 'No_Table', 'No_Table');
}
public function customer()
    {
        return $this->belongsTo(Customer::class, 'Customer_id','Customer_id');
    }
}
