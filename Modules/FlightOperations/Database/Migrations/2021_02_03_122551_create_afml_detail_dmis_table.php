<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfmlDetailDmisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afml_detail_dmis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('afm_log_id');
            $table->string('item_id'); // refer to id in aircraft configuration detail
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
        Schema::dropIfExists('aircraft_flight_maintenance_log_detail_defered_maintenance_items');
    }
}
