<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('ident');
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('latitude_deg')->nullable();
            $table->string('longitude_deg')->nullable();
            $table->string('elevation_ft')->nullable();
            $table->string('continent')->nullable();
            $table->string('iso_country')->nullable();
            $table->string('iso_region')->nullable();
            $table->string('municipality')->nullable();
            $table->string('scheduled_service')->nullable();
            $table->string('gps_code')->nullable();
            $table->string('iata_code')->nullable();
            $table->string('local_code')->nullable();
            $table->string('home_link')->nullable();
            $table->string('wikipedia_link')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            
            $table->rememberToken();
            $table->integer('status')->default(1)->nullable();
            $table->integer('owned_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('airports');
    }
}
