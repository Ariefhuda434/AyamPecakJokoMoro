<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipePivot extends Model
{
    protected $table = 'recipe_pivot'; 
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    protected $fillable = [
        'Stock_id',
        'Recipe_id',
        'Quantity',
        'Unit'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'Stock_id', 'Stock_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'Recipe_id', 'Recipe_id');
    }
}
