<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesToRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->string('notes')->after('purpose')->nullable();
            $table->integer('status')->after('division')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropColumn('status');
        });
    }
}
