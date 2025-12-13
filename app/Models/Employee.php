<?php

namespace App\Models;

// WAJIB: Ganti "Model" dengan "Authenticatable" dari framework Laravel
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

/**
 * Class Employee
 * Model ini digunakan untuk otentikasi (login) karena tidak ada tabel 'users'.
 * Model ini terhubung ke tabel 'employees' di database.
 */
class Employee extends Authenticatable 
{
    use Notifiable;
    protected $table = 'employees';
    
    protected $primaryKey = 'Employee_id';
    
    // public function getAuthIdentifierName()
    // {
    //     return 'name_employee'; 
    // }
    protected $fillable = [
        'name_employee',
        'password',
        'role_id', 
        'number_phone',
        'date_join',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_join' => 'datetime',
        'password' => 'hashed', 
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'Employee_id', 'Employee_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class, 'Employee_id', 'Employee_id');
    // }
    
}