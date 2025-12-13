<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'Audit_id';

    protected $table = 'log_audit';

    protected $fillable = [
        'Table_Name',
        'Record_ID',
        'Action_Typn',
        'Column_Name',
        'Old_Value',
        'New_Value',
        'Employee_id',
        'Change_Time',
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'Employee_id', 'Employee_id');
    }
}
