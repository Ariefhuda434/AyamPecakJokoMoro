<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipePivotTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_pivot', function (Blueprint $table) {
            $table->foreignId('Stock_id')->constrained('Stocks','Stock_id')->onDelete('cascade');
            $table->integer('Quantity');
            $table->foreignId('Recipe_id')->constrained('Recipies','Recipe_id')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_pivot');
    }
}