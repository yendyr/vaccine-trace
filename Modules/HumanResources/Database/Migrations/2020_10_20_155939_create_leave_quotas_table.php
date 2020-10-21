<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leave_quotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('empid', 20)->comment('Nomor NIK karyawan');
            $table->integer('quotayear')->comment('Tahun kuota');
            $table->string('quotacode', 2)->comment('Kode Quota');
            $table->date('quotastartdate')->comment('Tanggal Quota mulai bisa diambil')->nullable();
            $table->date('quotaexpdate')->comment('Tanggal batas akhir Quota')->nullable();
            $table->date('quotaallocdate')->comment('Tanggal alokasi quota')->nullable();
            $table->double('quotaqty')->comment('jumlah quota');
            $table->double('quotabal')->comment('sisa quota');
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
        Schema::dropIfExists('hr_leave_quotas');
    }
}
