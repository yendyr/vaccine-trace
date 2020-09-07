<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingHourDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_working_hour_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->date('workdate')->comment('Tanggal kehadiran  [format: Y-m-d]');
            $table->char('attdtype', 4)->comment('jenis kehadiran (i.e: 01=kerja, 02=Ijin semnetara')->nullable();
            $table->date('datestart')->comment('Tanggal masuk, [format: Y-m-d]')->nullable();
            $table->time('timestart')->comment('jam masuk, seperti 08:40:30')->nullable();
            $table->date('datefinish')->comment('Tanggal pulang, [format: Y-m-d]')->nullable();
            $table->time('timefinish')->comment('jam pulang, seperti 17:00:00')->nullable();
            $table->dateTime('processedon')->comment('waktu proses kalkulasi/re   (result')->nullable();
            $table->string('mainattd', 1)->comment('Kehadiran jam kerja [Y=yes, N=no]')->nullable();
            $table->date('caldatestart')->comment('Calculate tanggal mulai kehadiran, [format: Y-m-d]')->nullable();
            $table->time('caltimestart')->comment('Calculate jam mulai kehadiran, [ie: 07:30:15]')->nullable();
            $table->date('caldatefinish')->comment('Calculate tanggal brakhir kehadiran, [format: Y-m-d]')->nullable();
            $table->time('caltimefinish')->comment('Calculate jam selesai kehadiran, [ie: 07:30:15]')->nullable();

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
        Schema::dropIfExists('hr_working_hour_details');
    }
}
