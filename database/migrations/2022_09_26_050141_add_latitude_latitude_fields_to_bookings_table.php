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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('from_latitude');
            $table->string('from_longitude');
            $table->string('to_latitude');
            $table->string('to_longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('from_latitude');
            $table->dropColumn('from_longitude');
            $table->dropColumn('to_latitude');
            $table->dropColumn('to_longitude');
        });
    }
};