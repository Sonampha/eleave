<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            /**
             *  if we need add a foreign key constraint then
             *  the column should be unsigned integer
             */
        Schema::create('attendance_problems', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('request_date');
            $table->dateTime('att_date');  
            $table->string('staff_id', 20);       
            $table->string('att_status',100);
            $table->string('att_reason');
            $table->string('approver',100);
            $table->string('status',20); 
            $table->dateTime('status_date'); 
            $table->timestamps();
            
            /**
             *  Add Soft Deletes.
             * 
             *  it just mean that if we are deleting a row, then
             *  it will not delete row. it will just add a value to
             *  deleted_at column.
             */
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_problems');
    }
}
