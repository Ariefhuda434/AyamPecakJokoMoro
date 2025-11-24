<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('Customer_id');
            $table->string('Name');
            $table->string('Phone_Number');
            $table->foreignId('No_Table')->constrained('tables','No_Table');
            $table->timestamp('Created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
