<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('detail_order', function (Blueprint $table) {
            $table->id('Order_Detail');
            $table->foreignId('Menu_id')->constrained('menu')->onDelete('cascade');
            $table->foreignId('Order_id')->constrained('order')->onDelete('cascade');
            $table->integer('Quantity');
            $table->integer('Subtotal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_order');
    }
}