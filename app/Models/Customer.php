<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers'; 
    protected $primaryKey = 'Customer_id'; 
    public $timestamps = true; 
    
    protected $fillable = [
        'Name',
        'Phone_Number',
        'No_Table'
    ];
      public function table()
    {
        return $this->belongsTo(Table::class, 'No_Table', 'No_Table');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'Customer_id', 'Customer_id');
    }
}
