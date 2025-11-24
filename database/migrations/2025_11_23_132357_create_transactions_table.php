<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id('Transaction_id');
            $table->foreignId('Order_id')->constrained('order')->onDelete('cascade');
            $table->foreignId('Employee_id')->constrained('employee')->onDelete('cascade');
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
