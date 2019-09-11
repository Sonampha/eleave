<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveRecordsTable extends Migration
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
        Schema::create('leave_records', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('request_date');  
            $table->string('staff_id', 20);
            $table->string('staff_name',100);
            $table->string('leave_type',20);            
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('day_off',4,1);
            $table->string('unit',10);
            $table->string('reason');
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
        Schema::dropIfExists('leave_records');
    }
}
