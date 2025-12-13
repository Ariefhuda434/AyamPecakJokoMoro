<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
     protected $table = 'roles';
     protected $primaryKey = 'role_id';
       protected $fillable = [
        'role_name',
    ];
   public function employee()
    {
        return $this->hasMany(Employee::class, 'role_id','role_id');
    }   
}
