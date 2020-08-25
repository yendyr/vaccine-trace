<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_id_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->string('idcardtype', 10)->comment('tipe kartu identitas, ie: KTP, SIM, dll');
            $table->string('idcardno', 20)->comment('no. kartu identitas');
            $table->date('idcarddate')->comment('Tanggal kartu identitas')->nullable();
            $table->date('idcardexpdate')->comment('Tanggal lahir')->nullable();
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
        Schema::dropIfExists('hr_id_cards');
    }
}
