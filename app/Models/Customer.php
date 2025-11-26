<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'Customer_id';
    protected $table = 'customers';
       protected $fillable = [
        'Name',
        'Phone_Number',
        'No_Table',
        'Created_at'
    ];
}
