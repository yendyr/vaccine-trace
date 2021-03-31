<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskcardTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskcard_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            
            // $table->string('threshold_flight_hour')->nullable();
            // $table->string('threshold_flight_cycle')->nullable();
            // $table->string('threshold_daily')->nullable();
            // $table->string('threshold_daily_unit')->default('Year');
            // $table->date('threshold_date')->nullable();
            // $table->string('repeat_flight_hour')->nullable();
            // $table->string('repeat_flight_cycle')->nullable();
            // $table->string('repeat_daily')->nullable();
            // $table->string('repeat_daily_unit')->default('Year');
            // $table->date('repeat_date')->nullable();
            // $table->string('interval_control_method')->default('Which One Comes First');

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
        Schema::dropIfExists('taskcard_tags');
    }
}