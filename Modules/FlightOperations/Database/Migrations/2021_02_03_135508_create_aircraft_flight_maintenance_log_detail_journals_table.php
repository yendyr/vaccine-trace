<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftFlightMaintenanceLogDetailJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircraft_flight_maintenance_log_detail_journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('aircraft_flight_maintenance_logs_id');
            $table->string('route_from');
            $table->date('route_to');
            $table->time('block_off');
            $table->time('take_off');
            $table->time('landing');
            $table->time('block_on');
            $table->string('timezone');

            $table->integer('total_flight_hour');
            $table->integer('total_block_hour');
            $table->integer('total_cycle');
            $table->integer('total_event');

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
        Schema::dropIfExists('aircraft_flight_maintenance_log_detail_journals');
    }
}
