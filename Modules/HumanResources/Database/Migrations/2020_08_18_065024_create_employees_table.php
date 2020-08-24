<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**'
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->string('fullname', 50)->nullable();
            $table->string('nickname', 50)->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('pob', 30)->comment('kota Tempat lahir')->nullable();
            $table->date('dob')->comment('Tanggal lahir')->nullable();
            $table->char('gender', 1)->comment('jenis kelamin')->nullable();
            $table->string('religion', 15)->nullable();
            $table->string('mobile01', 20)->comment('Nomor hp 1')->nullable();
            $table->string('mobile02', 20)->comment('Nomor hp 2')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('bloodtype', 4)->comment('goldar, ie: A, O, AB+, AB-')->nullable();
            $table->char('maritalstatus', 1)->comment('status nikah, ie: M/L/D/J')->nullable();
            $table->date('empdate')->comment('Tanggal masuk karyawan')->nullable();
            $table->char('probation', 1)->comment('masa percobaan, ie: Y/N')->nullable();
            $table->date('cessdate')->comment('Tanggal keluar karyawan')->nullable();
            $table->char('cesscode', 2)->comment('masa percobaan, ie: 01 (resign), 02 (retire)')->nullable();
            $table->string('recruitby', 4)->comment('perekrut, dropdown ambil dari tabel lookup')->nullable();
            $table->string('emptype', 2)->comment('kode grup karyawan, ie: 22 = temporary borongan')->nullable();
            $table->string('workgrp', 4)->comment('data dari Workgroup')->nullable();
            $table->string('site', 4)->comment('kode site -development')->nullable();
            $table->string('accsgrp', 4)->comment('kode access group -development')->nullable();
            $table->string('achgrp', 4)->comment('kode achievement group -development')->nullable();
            $table->string('orglvl', 4)->comment('org level otomatis keisi ketika memilih orgcode')->nullable();
            $table->string('orgcode', 6)->comment('ambil dari tabel org')->nullable();
            $table->string('title', 2)->comment('kode jabatan ambil dari titlecode')->nullable();
            $table->string('jobtitle', 100)->comment('otomatis keisi kalo title nya dipilih')->nullable();
            $table->string('jobgrp', 4)->comment('kode grup kerja')->nullable();
            $table->string('costcode', 10)->comment('kode cost center')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
