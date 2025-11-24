<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    public function up()
    {
        Schema::create('Stocks', function (Blueprint $table) {
            $table->id('Stock_id');
            $table->string('Name_Stock');
            $table->string('Unit');
            $table->integer('Current_Stock');
            $table->integer('Min_Stock_Level');
            $table->integer('Last_Cost');
            $table->integer('Last_Updated');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock');
    }
}