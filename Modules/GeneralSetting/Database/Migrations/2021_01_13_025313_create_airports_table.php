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
            $table->increments('id')
                ->comment('table to store airports data');
            $table->string('ident', 10)
                ->comment('airport identity')
                ->unique();
            $table->string('type', 20);
            $table->string('name', 175);
            $table->double('latitude_deg', 16, 10)
                ->nullable(false)
                ->default(0);
            $table->double('longitude_deg', 16, 10)
                ->nullable(false)
                ->default(0);
            $table->integer('elevation_ft');
            $table->string('continent', 5);
            $table->string('iso_country', 5);
            $table->string('iso_region', 10);
            $table->string('municipality', 75);
            $table->string('scheduled_service', 5);
            $table->string('gps_code', 5);
            $table->string('iata_code', 5);
            $table->string('local_code', 20);
            $table->string('home_link');
            $table->string('wikipedia_link');
            $table->text('keywords');
            
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
