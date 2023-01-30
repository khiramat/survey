<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_results', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->integer('respondent_user_id')->nullable(false);
            $table->boolean('delete_flg')->default(false)->nullable(false);
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
        Schema::dropIfExists('answer_results');
    }
};
