<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class
CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->integer('txnperiod')->comment('Periode Transaksi');
            $table->string('reqcode', 4)->comment('Kode transaksi [ie:01=Leave,02=Overtime,03=Working Hour]');
            $table->string('reqtype', 4)->comment('Kode ijin/lembur [ie:01=Awal,02=Tengah]');
            $table->string('docno', 20)->comment('Documnent Number');
            $table->date('docdate')->comment('Documnent date');
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->date('workdate')->comment('Tanggal kehadiran  [format: Y-m-d]');
            $table->char('shiftno', 1)->comment('jadwal shift');
            $table->date('whdatestart')->comment('Tanggal masuk, [format: Y-m-d]')->nullable();
            $table->time('whtimestart')->comment('jam masuk, seperti 08:00:00')->nullable();
            $table->date('whdatefinish')->comment('Tanggal pulang, [format: Y-m-d]')->nullable();
            $table->time('whtimefinish')->comment('jam pulang, seperti 17:00:00')->nullable();
            $table->date('rsdatestart')->comment('Tanggal mulai istirahat, [format: Y-m-d]')->nullable();
            $table->time('rstimestart')->comment('jam mulai istirahat, seperti 11:30:00')->nullable();
            $table->date('rsdatefinish')->comment('Tanggal selesai istirahat, [format: Y-m-d]')->nullable();
            $table->time('rstimefinish')->comment('jam berakhir istirahat, seperti 11:30:00')->nullable();
            $table->char('workstatus', 1)->comment('status kerja (i.e: M=masuk, L=libur')->nullable();
            $table->integer('quotayear')->comment('Tahun pemotongan quota leave');
            $table->string('remark', 100)->nullable();

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
        Schema::dropIfExists('hr_requests');
    }
}
