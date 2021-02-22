<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircraft_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('aircraft_type_id');
            $table->string('maintenance_program_id');
            
            $table->string('registration_number');
            $table->string('serial_number')->nullable();
            $table->date('manufactured_date')->nullable();
            $table->date('received_date')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->integer('max_takeoff_weight')->nullable();
            $table->string('max_takeoff_weight_unit_id')->nullable();
            $table->integer('max_landing_weight')->nullable();
            $table->string('max_landing_weight_unit_id')->nullable();
            $table->integer('max_zero_fuel_weight')->nullable();
            $table->string('max_zero_fuel_weight_unit_id')->nullable();

            $table->integer('fuel_capacity')->nullable();
            $table->string('fuel_capacity_unit_id')->nullable();
            $table->integer('basic_empty_weight')->nullable();
            $table->string('basic_empty_weight_unit_id')->nullable();

            $table->double('initial_flight_hour')->nullable()->default(0);
            $table->double('initial_block_hour')->nullable()->default(0);
            $table->integer('initial_flight_cycle')->nullable()->default(0);
            $table->integer('initial_flight_event')->nullable()->default(0);
            $table->datetime('initial_start_date')->nullable()->default(\DB::RAW('CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('aircraft_configurations');
    }
}
