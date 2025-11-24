<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id('Employee_id');
            $table->string('Name');
            $table->string('Password');
            $table->string('No_Telepon');
            $table->string('Role'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
