<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    use Sluggable;
    protected $primaryKey = 'Menu_id';

    protected $table = 'menus';


    protected $fillable = [
        'Category',
        'Name',
        'Price',
        'Menu_Status',
        'photo',
        'Recipe_id',
    ];

      public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'Recipe_id', 'Recipe_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'Menu_id', 'Menu_id');
    }
    
   public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'Name'
            ]
        ];
    }
}
