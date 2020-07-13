<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('start_day')->default(0);
            $table->float('level_mood_10',6,2)->nullable();
            $table->float('level_mood_9',6,2)->nullable();
            $table->float('level_mood_8',6,2)->nullable();
            $table->float('level_mood_7',6,2)->nullable();
            $table->float('level_mood_6',6,2)->nullable();
            $table->float('level_mood_5',6,2)->nullable();
            $table->float('level_mood_4',6,2)->nullable();
            $table->float('level_mood_3',6,2)->nullable();
            $table->float('level_mood_2',6,2)->nullable();
            $table->float('level_mood_1',6,2)->nullable();
            $table->float('level_mood0',6,2)->nullable();
            $table->float('level_mood1',6,2)->nullable();
            $table->float('level_mood2',6,2)->nullable();
            $table->float('level_mood3',6,2)->nullable();
            $table->float('level_mood4',6,2)->nullable();
            $table->float('level_mood5',6,2)->nullable();
            $table->float('level_mood6',6,2)->nullable();
            $table->float('level_mood7',6,2)->nullable();
            $table->float('level_mood8',6,2)->nullable();
            $table->float('level_mood9',6,2)->nullable();
            $table->float('level_mood10',6,2)->nullable();
            $table->float('level_mood_10_to',6,2)->nullable();
            $table->float('level_mood_9_to',6,2)->nullable();
            $table->float('level_mood_8_to',6,2)->nullable();
            $table->float('level_mood_7_to',6,2)->nullable();
            $table->float('level_mood_6_to',6,2)->nullable();
            $table->float('level_mood_5_to',6,2)->nullable();
            $table->float('level_mood_4_to',6,2)->nullable();
            $table->float('level_mood_3_to',6,2)->nullable();
            $table->float('level_mood_2_to',6,2)->nullable();
            $table->float('level_mood_1_to',6,2)->nullable();
            $table->float('level_mood0_to',6,2)->nullable();
            $table->float('level_mood1_to',6,2)->nullable();
            $table->float('level_mood2_to',6,2)->nullable();
            $table->float('level_mood3_to',6,2)->nullable();
            $table->float('level_mood4_to',6,2)->nullable();
            $table->float('level_mood5_to',6,2)->nullable();
            $table->float('level_mood6_to',6,2)->nullable();
            $table->float('level_mood7_to',6,2)->nullable();
            $table->float('level_mood8_to',6,2)->nullable();
            $table->float('level_mood9_to',6,2)->nullable();
            $table->float('level_mood10_to',6,2)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
