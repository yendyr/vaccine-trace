<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockMutationDetailInitialAgingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_mutation_detail_initial_agings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('stock_mutation_detail_id');

            $table->date('expired_date')->nullable();
            $table->double('initial_flight_hour')->nullable()->default(0);
            $table->double('initial_block_hour')->nullable()->default(0);
            $table->integer('initial_flight_cycle')->nullable()->default(0);
            $table->integer('initial_flight_event')->nullable()->default(0);
            $table->date('initial_start_date')->nullable();

            $table->string('description')->nullable();
            
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
        Schema::dropIfExists('stock_mutation_detail_inital_agings');
    }
}
