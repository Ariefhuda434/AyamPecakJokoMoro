<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'Stock_id';
    public $timestamps = false; // Kalau tabel tidak memakai created_at & updated_at

    protected $fillable = [
        'Name_Stock',
        'unit',
        'Current_Stock',
        'Min_Stock_Level',
        'Last_Cost'
    ];

    public function restockLogs()
    {
        return $this->hasMany(RestockLog::class, 'Stock_id', 'Stock_id');
    }

    public function recipePivots()
    {
        return $this->hasMany(RecipePivot::class, 'Stock_id', 'Stock_id');
    }

}
