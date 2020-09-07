<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_working_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->date('workdate')->comment('Tanggal kehadiran  [format: Y-m-d]');
            $table->char('shiftno', 1)->comment('nomor shift');
            $table->date('whdatestart')->comment('Tanggal masuk, [format: Y-m-d]')->nullable();
            $table->time('whtimestart')->comment('jam masuk, seperti 08:00:00')->nullable();
            $table->date('whdatefinish')->comment('Tanggal pulang, [format: Y-m-d]')->nullable();
            $table->time('whtimefinish')->comment('jam pulang, seperti 17:00:00')->nullable();
            $table->date('rsdatestart')->comment('Tanggal mulai istirahat, [format: Y-m-d]')->nullable();
            $table->time('rstimestart')->comment('jam mulai istirahat, seperti 11:30:00')->nullable();
            $table->date('rsdatefinish')->comment('Tanggal selesai istirahat, [format: Y-m-d]')->nullable();
            $table->time('rstimefinish')->comment('jam berakhir istirahat, seperti 11:30:00')->nullable();
            $table->integer('stdhours')->comment('standard jam kerja (satuan jam)')->nullable();
            $table->integer('minhours')->comment('minimum jam kerja (satuan jam)')->nullable();
            $table->char('worktype', 2)->comment('jenis kerja (i.e: KB=kerja biasa, KL=Kerja libur')->nullable();
            $table->char('workstatus', 1)->comment('status kerja (i.e: M=masuk, L=libur')->nullable();
            $table->dateTime('processedon')->comment('waktu proses kalkulasi/re   (result')->nullable();
            $table->double('leavehours')->comment('jumlah total jam ijin semetara/ijin potong jam kerja')->nullable();
            $table->double('attdhours')->comment('jumlah total jam kehadiran [jam kerja dan lembur (awal & akhir)]')->nullable();
            $table->double('overhours')->comment('jumlah total jam lembur lain')->nullable();
            $table->string('attdstatus', 2)->comment('status kehadiran [ie: 01=hadir,02=mangkir,03=ijin]')->nullable();

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
        Schema::dropIfExists('hr_working_hours');
    }
}
