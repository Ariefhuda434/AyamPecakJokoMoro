<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipiesTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
             $table->foreignId('Customer_id')->constrained('menu')->onDelete('cascade');
             $table->foreignId('Employee_id')->constrained('order')->onDelete('cascade');
             $table->string('Order_Status');
             $table->text('Notes');
             $table->integer('No_Table');

        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe');
    }
}