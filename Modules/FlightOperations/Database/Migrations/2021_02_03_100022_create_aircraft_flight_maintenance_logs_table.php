<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftFlightMaintenanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircraft_flight_maintenance_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('page_number');
            $table->string('previous_page_number');
            $table->date('transaction_date');
            $table->string('aircraft_configuration_id');
            $table->date('last_inspection');
            $table->date('next_inspection');

            $table->datetime('pre_flight_check_date');
            $table->datetime('pre_flight_check_place');
            $table->datetime('pre_flight_check_nearest_airport');
            $table->datetime('pre_flight_check_person');
            $table->datetime('pre_flight_check_compressor_wash');

            $table->datetime('post_flight_check_date');
            $table->datetime('post_flight_check_place');
            $table->datetime('post_flight_check_nearest_airport');
            $table->datetime('post_flight_check_person');
            $table->datetime('post_flight_check_compressor_wash');

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
        Schema::dropIfExists('aircraft_flight_maintenance_logs');
    }
}
