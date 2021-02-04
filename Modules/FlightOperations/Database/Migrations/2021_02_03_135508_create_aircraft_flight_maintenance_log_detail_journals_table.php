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
            $table->time('block_off')->nullable();
            $table->time('take_off')->nullable();
            $table->time('landing')->nullable();
            $table->time('block_on')->nullable();
            $table->string('timezone')->nullable();

            $table->integer('total_flight_hour')->nullable();
            $table->integer('total_block_hour')->nullable();
            $table->integer('total_cycle')->nullable();
            $table->integer('total_event')->nullable();

            $table->integer('fuel_remaining')->nullable();
            $table->string('fuel_remaining_unit_id')->nullable();
            $table->integer('fuel_uplifted')->nullable();
            $table->string('fuel_uplifted_unit_id')->nullable();
            $table->integer('fuel_block')->nullable();
            $table->string('fuel_block_unit_id')->nullable();
            $table->integer('fuel_burned')->nullable();
            $table->string('fuel_burned_unit_id')->nullable();
            $table->string('fuel_receipt_number')->nullable();
            $table->string('fuel_uplifted_unit_id')->nullable();

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
