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
//            gen merch id
            $table->unsignedBigInteger('gen_merch_id')->nullable();
            $table->foreign('gen_merch_id')->references('id')->on('gen_merches');
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
            $table->dropForeign(['gen_merch_id']);
            $table->dropColumn('gen_merch_id');
        });
    }
};
