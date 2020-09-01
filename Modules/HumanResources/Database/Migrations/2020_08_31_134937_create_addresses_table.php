<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->string('famid', 20)->comment('Nomor ID family');
            $table->string('addrid', 20)->comment('Nomor ID address');
            $table->string('street')->nullable();
            $table->string('area', 30)->nullable()->comment('kecamatan');
            $table->string('city', 30)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('country', 30)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('tel01', 20)->nullable()->comment('no. telephon');
            $table->string('tel02', 20)->nullable()->comment('no. telephon');
            $table->string('remark')->nullable();

            $table->integer('status')->nullable();
            $table->integer('owned_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
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
        Schema::dropIfExists('hr_addresses');
    }
}
