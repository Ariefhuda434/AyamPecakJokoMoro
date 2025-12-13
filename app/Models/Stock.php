<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'Stock_id';

    protected $fillable = [
        'Name_Stock',
        'Unit',
        'Current_Stock',
        'Min_Stock_Level',
        'Last_Cost'
    ];

    public function restockLogs()
    {
        return $this->hasMany(RestockLog::class, 'Stock_id', 'Stock_id');
    }
    
    
    public function recipes()
{
    return $this->belongsToMany(
        Recipe::class, 
        'recipe_pivot', 
        'Stock_id',               
        'Recipe_id'               
    );
}

}
