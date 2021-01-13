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
            $table->string('ident', 10);
            $table->string('type', 20)->nullable();
            $table->string('name', 175);
            $table->double('latitude_deg', 16, 10)->nullable(false)->default(0);
            $table->double('longitude_deg', 16, 10)->nullable(false)->default(0);
            $table->integer('elevation_ft')->nullable();
            $table->string('continent', 5)->nullable();
            $table->string('iso_country', 5)->nullable();
            $table->string('iso_region', 10)->nullable();
            $table->string('municipality', 75)->nullable();
            $table->string('scheduled_service', 5)->nullable();
            $table->string('gps_code', 5)->nullable();
            $table->string('iata_code', 5)->nullable();
            $table->string('local_code', 20)->nullable();
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
            $table->timestamps();
            $table->softDeletes();
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
