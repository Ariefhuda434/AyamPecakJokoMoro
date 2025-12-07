<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id('Menu_id');
            $table->string('Category');
            $table->string('Name');
            $table->integer('Price');
            $table->string('Menu_Status');
            $table->foreignId('Recipe_id')->nullable()->constrained('Recipies','Recipe_id')->onDelete('cascade');
            $table->string('photo')->nullable(); 
            $table->timestamps(); 
        });
    }
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}