<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->string('famid', 20)->comment('Nomor ID family');
            $table->string('relationship', 2)->comment('Hubungan Keluarga');
            $table->string('fullname', 100)->comment('Nama lengkap');
            $table->string('pob', 30)->comment('kota Tempat lahir');
            $table->date('dob')->comment('Tanggal lahir');
            $table->char('gender', 1)->comment('jenis kelamin');
            $table->char('maritalstatus', 1)->comment('status nikah, ie: M/L/D/J');
            $table->string('edulvl', 50)->comment('Jenjang pendidikan (ie: S1,D3)');
            $table->string('edumajor', 50)->comment('Jurusan pendidikan')->nullable();
            $table->char('job', 2)->comment('Pekerjaan (ie: 01=Pelajar, 02=Swasta)');
            $table->string('remark', 50)->nullable();

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
        Schema::dropIfExists('hr_families');
    }
}
