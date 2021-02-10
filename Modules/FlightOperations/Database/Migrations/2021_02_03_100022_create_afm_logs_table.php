<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afm_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('page_number');
            $table->string('previous_page_number')->nullable();
            $table->date('transaction_date');
            $table->string('aircraft_configuration_id');
            $table->date('last_inspection')->nullable();
            $table->date('next_inspection')->nullable();

            $table->datetime('pre_flight_check_date')->nullable();
            $table->string('pre_flight_check_place')->nullable();
            $table->string('pre_flight_check_nearest_airport_id')->nullable();
            $table->string('pre_flight_check_person_id')->nullable();
            $table->string('pre_flight_check_compressor_wash')->nullable();

            $table->datetime('post_flight_check_date')->nullable();
            $table->string('post_flight_check_place')->nullable();
            $table->string('post_flight_check_nearest_airport_id')->nullable();
            $table->string('post_flight_check_person_id')->nullable();
            $table->string('post_flight_check_compressor_wash')->nullable();

            $table->double('total_flight_hour');
            $table->double('total_block_hour');
            $table->integer('total_flight_cycle');
            $table->integer('total_flight_event');

            $table->rememberToken();
            $table->integer('status')->nullable();
            $table->integer('owned_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['page_number', 'aircraft_configuration_id']);
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
