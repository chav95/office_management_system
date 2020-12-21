<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('waktu_urus')->after('description')->nullable();
            $table->string('unit')->after('waktu_urus')->nullable();
            $table->string('bagian')->after('unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('waktu_urus');
            $table->dropColumn('unit');
            $table->dropColumn('bagian');
        });
    }
}
