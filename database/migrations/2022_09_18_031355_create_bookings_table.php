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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->string('t_trip_start')->nullable();
            $table->string('t_trip_end')->nullable();
            $table->uuid('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users');
            $table->date('trip_start_date')->nullable();
            $table->date('trip_end_date')->nullable();
            $table->integer('t_total_distance')->default(0);
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
        Schema::dropIfExists('bookings');
    }
};
