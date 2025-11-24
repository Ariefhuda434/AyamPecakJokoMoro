<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('Transaction_id');
            $table->foreignId('Order_id')->constrained('orders','Order_id')->onDelete('cascade');
            $table->foreignId('Employee_id')->constrained('employees','Employee_id')->onDelete('cascade');
            $table->string('Method_Payment');
            $table->string('Status');
            $table->integer('Total_Price');
            $table->timestamp('Date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
