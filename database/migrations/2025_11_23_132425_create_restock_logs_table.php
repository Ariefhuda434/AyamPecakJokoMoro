<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestockLogsTable extends Migration
{
    public function up()
    {
        Schema::create('restock_log', function (Blueprint $table) {
            $table->id('Restock_id');
            $table->foreignId('Stock_id')->constrained('Stocks','Stock_id')->onDelete('cascade');
            $table->integer('Stock_Before');
            $table->integer('Update_Quantity');
            $table->string('unit');
            $table->integer('Price');
            $table->timestamp('Date_in')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restock_log');
    }
}
