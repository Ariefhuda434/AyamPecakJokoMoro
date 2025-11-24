<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipePivotTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Stock_id')->constrained('stock')->onDelete('cascade');
            $table->integer('Quantity');
            $table->string('Unit');
            $table->foreignId('Recipe_id')->constrained('recipe')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_pivot');
    }
}