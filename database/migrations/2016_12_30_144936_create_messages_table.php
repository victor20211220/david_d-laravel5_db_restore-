<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('messages', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('email_alt');
            $table->string('phone');
            $table->string('phone_alt');
            $table->string('province');
            $table->string('city');
            $table->string('area');
            $table->string('suburb');
            $table->string('numberOfLeads');
            $table->string('industry');
            $table->string('message');
            $table->enum("status", array("sent", "review", "followedup"));
            $table->enum("type", array("call", "copy"));
            $table->integer('operator_id');
            $table->string('operator_name');
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
        Schema::drop('messages');
    }
}
