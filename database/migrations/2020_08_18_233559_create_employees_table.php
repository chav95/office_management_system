<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nik');
            $table->string('name');
            $table->string('npwp')->nullable();
            $table->date('entry_date');
            $table->integer('gaji_tunjangan', 17)->nullable();
            $table->integer('terima_pph', 17)->nullable();
            $table->integer('total_terima_lain', 17)->nullable();
            $table->integer('total_potongan_lain', 17)->nullable();
            $table->integer('total_potongan_pph', 17)->nullable();
            $table->integer('jumlah_penerimaan', 17)->nullable();
            $table->integer('jumlah_potongan', 17)->nullable();
            $table->integer('penerimaan_bersih', 17)->nullable();
            $table->integer('pengurang', 17)->nullable();
            $table->integer('penerimaan', 17)->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
