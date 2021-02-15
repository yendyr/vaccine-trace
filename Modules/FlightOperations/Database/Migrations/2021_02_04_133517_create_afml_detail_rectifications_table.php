<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfmlDetailRectificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afml_detail_rectifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('afm_log_id');
            $table->string('afml_detail_discrepancy_id')->nullable();
            $table->string('code')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('performed_by')->nullable();

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
        Schema::dropIfExists('aircraft_flight_maintenance_log_detail_rectifications');
    }
}
