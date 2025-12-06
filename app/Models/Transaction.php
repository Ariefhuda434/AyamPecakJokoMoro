<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'Transaction_id';
    public $timestamps = false;

    protected $fillable = [
        'Order_id',
        'Employee_id',
        'Method_Payment',
        'Status',
        'Total_Price',
        'Date'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_id', 'Order_id');
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'Employee_id', 'Employee_id');
    }
}
