<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInLeusTable extends Migration
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
        Schema::create('in_leus', function (Blueprint $table) {
            $table->increments('id');
            $table->date('inleu_date');
            $table->string('staff_id', 20);        
            $table->decimal('inleu_day',4,1);
            $table->string('reason');
            $table->timestamps();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('in_leus');
    }
}
