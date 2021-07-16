<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'appointments',
            function (Blueprint $table) {
                $table->foreignId('instructor_id')
                      ->constrained();
            }
        );
        Schema::table(
            'appointments',
            function (Blueprint $table) {
                $table->foreignId('user_id')
                      ->constrained();
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
        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->dropForeign('appointments_user_id_foreign');
            }
        );
        Schema::table(
            'instructors',
            function (Blueprint $table) {
                $table->dropForeign('appointments_instructor_id_foreign');
            }
        );
    }
}
