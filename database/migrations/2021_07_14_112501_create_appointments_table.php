<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'appointments',
            function (Blueprint $table) {
                $table->id();
                $table->date('start_time');
                $table->integer('user_id');
                $table->integer('instructor_id');
                $table->timestamps();
            }
        );
        Schema::table(
            'instructors',
            function (Blueprint $table) {
                $table->foreignId('instructor_id')->constrained();
            }
        );
        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->foreignId('user_id')->constrained();
            }
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
