<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->char('attdtype', 4)->comment('jenis kehadiran (i.e: 01IN=masuk kerja')->nullable();
            $table->date('attddate')->comment('Tanggal hadir  [format: Y-m-d]')->nullable();
            $table->time('attdtime')->comment('waktu hadir, seperti 17:00:00')->nullable();
            $table->string('deviceid', 5)->comment('nomor mesin [ie: 01=Device 01/XX=manual')->nullable();
            $table->dateTime('inputon')->comment('tanggal dan waktu input data')->nullable();

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
        Schema::dropIfExists('hr_attendances');
    }
}
