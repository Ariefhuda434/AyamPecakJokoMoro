<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'Menu_id';

    protected $table = 'menus';

    public $timestamps = false;

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
}
