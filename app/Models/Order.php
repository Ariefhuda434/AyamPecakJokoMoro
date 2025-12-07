<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'Order_id';
    protected $table = 'orders';
       protected $fillable = [
        'Customer_id',
        'Employee_id',
        'No_Table',
        'Order_Status',
        'Notes'
    ];

     public function customer()
    {
        return $this->belongsTo(Customer::class, 'Customer_id', 'Customer_id');
    }
     public function table()
    {
        return $this->belongsTo(Table::class, 'No_Table', 'No_Table');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'Employee_id', 'Employee_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'Order_id', 'Order_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'Order_id', 'Order_id');
    }
}
