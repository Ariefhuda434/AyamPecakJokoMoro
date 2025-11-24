<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'Employee_id';
    protected $table = 'employees'; 
    protected $fillable = [
        'name_employee',
        'number_phone',
        'role',
        'password',
        'date_join',
    ];
    protected $casts = [
        'date_join' => 'date',
    ];
}
