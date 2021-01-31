<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftConfigurationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircraft_configuration_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('coding')->nullable();
            $table->string('aircraft_configuration_template_id');
            $table->string('item_id');
            $table->string('serial_number');
            $table->string('alias_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('highlight')->default(0)->nullable();
            $table->string('parent_coding')->nullable();

            $table->integer('initial_flight_hour')->nullable();
            $table->integer('initial_flight_cycle')->nullable();
            $table->date('initial_start_date')->nullable();

            $table->rememberToken();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('aircraft_configuration_details');
    }
}
