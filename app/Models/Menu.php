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
}
