<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_logs', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('Customer_id')->nullable(); 
            $table->string('Name', 20);
            $table->string('Phone_Number', 14);
            $table->integer('No_Table'); 
            $table->string('action', 50); 
            $table->timestamp('log_time'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_logs');
    }
};