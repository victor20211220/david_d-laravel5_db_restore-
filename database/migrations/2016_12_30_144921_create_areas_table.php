<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('areas', function(Blueprint $table){
            $table->increments('id');
            $table->text('province');
            $table->text('city');
            $table->text('area');
            $table->text('suburb');
            $table->text('stripped_area');
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
        //
        Schema::drop('areas');
    }
}
