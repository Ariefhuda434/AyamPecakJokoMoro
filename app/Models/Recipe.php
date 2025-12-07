<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    
protected $primaryKey = 'Recipe_id';

    protected $table = 'recipies';

    protected $fillable = [
        'Recipe_id',
        'Name',
        'Keterangan',
    ];      
    public function menus()
{
    return $this->belongsToMany(Menu::class, 'menu_recipe_pivot', 'Recipe_id', 'Menu_id');
}
}
