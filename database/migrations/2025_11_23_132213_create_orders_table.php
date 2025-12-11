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
            $table->foreignId('No_Table')->constrained('tables','No_Table')->nullable();
            $table->integer('Total');
            $table->enum('Order_Status', ['Belum Memesan','Memesan'])->default('Belum Memesan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe');
    }
}