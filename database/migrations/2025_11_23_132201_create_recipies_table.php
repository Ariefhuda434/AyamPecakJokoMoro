<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipiesTable extends Migration
{
    public function up()
    {
        Schema::create('Recipies', function (Blueprint $table) {
            $table->id('Recipe_id');
            $table->string('Name_Resep');
            $table->text('Keterangan')->nullable();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe');
    }
}
