<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_id', 20);
            $table->string('staff_name',100);
            $table->integer('gender_id')->unsigned();
            $table->integer('nationality_id')->unsigned(); 
            $table->date('birth_date');
            $table->string('email',100);
            $table->string('phone',100);
            $table->longText('address');
            $table->date('join_date');            
            $table->integer('dept_id')->unsigned();
            $table->integer('functional_id')->unsigned();
            $table->integer('job_title_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('reporting_manager_id')->unsigned();
            $table->string('work_day',20);
            $table->tinyInteger('have_direct_report');
            $table->string('picture');
            $table->decimal('ann_leave',4,1);
            $table->decimal('sick_leave',4,1);
            $table->decimal('mat_leave',4,1);
            $table->decimal('hop_leave',4,1);
            $table->decimal('unp_leave',4,1);
            $table->decimal('spec_leave',4,1);
            $table->decimal('carry_leave',4,1);

            /**
             *  Add foreign key constraints to these columns
             */

            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('functional_id')->references('id')->on('functionals');
            $table->foreign('job_title_id')->references('id')->on('job_titles');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('reporting_manager_id')->references('id')->on('reporting_managers');
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
        Schema::dropIfExists('employees');
    }
}
