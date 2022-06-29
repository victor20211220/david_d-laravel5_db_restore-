<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('contractor', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->longText('industry');
            $table->string('province');
            $table->string('city');
            $table->longText('area');
            $table->longText('overallArea');
            $table->text('notes');
            $table->longText('emails');
            $table->longText('phones');
            $table->integer('leads_remaining');
            $table->enum('leads_status', array(0, 1));
            $table->string('last_lead');
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
        Schema::drop('contractor');
    }
}
