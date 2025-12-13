<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    
protected $primaryKey = 'Recipe_id';

    protected $table = 'recipies';
public $timestamps = false;
    protected $fillable = [
        'Name_Resep',
        'Keterangan',
    ];      
    
    public function menus()
    {
        return $this->hasOne(Menu::class, 'Recipe_id', 'Recipe_id');
    }

    public function stocksMagic()
{
    return $this->belongsToMany(
        Stock::class,'recipe_pivot', 
        'Recipe_id','Stock_id'
    )->withPivot('Quantity'); 
}
}
