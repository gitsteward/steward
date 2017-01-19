<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_code');
            $table->string('name');
            $table->string('email');
            $table->enum('gender', array('male', 'female', 'other'));
            $table->string('lang', 15); // For long lang like 'zh-hant-cn'
            $table->timestamps();

            $table->foreign('report_code')->references('code')->on('reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
