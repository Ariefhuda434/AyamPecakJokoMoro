<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('Employee_id');
            $table->string('name_employee');
            $table->string('number_phone');
            $table->string('remember_token')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles', 'role_id')->onDelete('set null');
            $table->string('password');
            $table->date('date_join');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
