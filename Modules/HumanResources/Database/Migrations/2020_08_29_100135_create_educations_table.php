<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_educations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->string('instname', 100)->comment('Nama instansi pendidikan');
            $table->string('startperiod', 4)->comment('Tahun masuk pendidikan');
            $table->string('finishperiod', 4)->comment('Tahun masuk pendidikan');
            $table->string('city', 30)->comment('Kota tempat pendidikan');
            $table->string('state', 30)->comment('Provinsi tempat pendidikan');
            $table->string('country', 30)->comment('Negara tempat pendidikan');
            $table->string('major01', 50)->comment('Jurusan pendidikan mayor 1')->nullable();
            $table->string('major02', 50)->comment('Jurusan pendidikan mayor 2')->nullable();
            $table->string('minor01', 50)->comment('Jurusan pendidikan minor 1')->nullable();
            $table->string('minor02', 50)->comment('Jurusan pendidikan minor 2')->nullable();
            $table->string('edulvl', 50)->comment('Jenjang pendidikan (ie: S1,D3)');
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
        Schema::dropIfExists('hr_education');
    }
}
