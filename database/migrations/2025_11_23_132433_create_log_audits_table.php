<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAuditsTable extends Migration
{
    public function up()
    {

Schema::create('audit_logs', function (Blueprint $table) {
    $table->id('Audit_id');
    $table->string('Table_Name');
    $table->integer('Record_ID');
    $table->string('Action_Typn');
    $table->string('Column_Name');
    $table->text('Old_Value')->nullable();
    $table->text('New_Value')->nullable();
    $table->foreignId('Employee_id')->constrained('Employees','Employee_id'); 
    $table->timestamp('Change_time')->nullable();
    $table->timestamps(); 
});
    }

    public function down()
    {
        Schema::dropIfExists('log_audit');
    }
}
