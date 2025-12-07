<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'Menu_id';

    protected $table = 'menus';


    protected $fillable = [
        'Category',
        'Name',
        'Price',
        'Menu_Status',
        'Recipe_id',
        'photo',
    ];

      public function recipe()
    {
        return $this->hasOne(Recipe::class, 'Recipe_id', 'Recipe_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'Menu_id', 'Menu_id');
    }
    public function recipes()
    {
    return $this->belongsToMany(Recipe::class, 'menu_recipe_pivot', 'Menu_id', 'Recipe_id')
                ->withPivot('Quantity', 'Unit');
}
}
