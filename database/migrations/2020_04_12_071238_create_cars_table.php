<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->integer('company_id');
            // $table->string('type');
            // $table->string('engine_cc');
            // $table->string('police_number');
            // $table->string('driver_id');
            // $table->date('lease_start');
            // $table->date('lease_due');
            // $table->integer('lease_price');
            // $table->integer('vendor_id');
            // $table->integer('division_id');
            // $table->integer('created_by');
            // $table->timestamps();

            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('type');
            $table->integer('engine_cc');
            $table->string('police_number');
            $table->string('driver_name');
            $table->date('lease_start')->nullable();
            $table->date('lease_due')->nullable();
            $table->integer('lease_price')->nullable();
            $table->string('vendor_name');
            $table->string('division_name');
            $table->integer('created_by');
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
        Schema::dropIfExists('cars');
    }
}
