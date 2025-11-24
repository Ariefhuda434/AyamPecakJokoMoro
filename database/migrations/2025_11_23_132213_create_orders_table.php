<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('Order_id');
             $table->foreignId('Customer_id')->constrained('customers','Customer_id')->onDelete('cascade');
             $table->foreignId('Employee_id')->constrained('employees','Employee_id')->onDelete('cascade');
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