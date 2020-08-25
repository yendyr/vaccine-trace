<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_working_group_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('workgroup', 4);
            $table->char('daycode', 2)->comment('i.e: 01=AHAD, 02=SENIN, dst.');
            $table->char('shiftno', 1)->comment('nomor shift');
            $table->string('whtimestart', 10)->comment('jam masuk, seperti 08:00:00')->nullable();
            $table->string('whtimefinish', 10)->comment('jam pulang, seperti 17:00:00')->nullable();
            $table->string('rstimestart', 10)->comment('jam mulai istirahat, seperti 11:30:00')->nullable();
            $table->string('rstimefinish', 10)->comment('jam berakhir istirahat, seperti 11:30:00')->nullable();
            $table->integer('stdhours')->comment('standard jam kerja (satuan jam)')->nullable();
            $table->integer('minhours')->comment('minimum jam kerja (satuan jam)')->nullable();
            $table->char('worktype', 2)->comment('jenis kerja (i.e: KB=kerja biasa, KL=Kerja libur');

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
        Schema::dropIfExists('hr_working_group_details');
    }
}
