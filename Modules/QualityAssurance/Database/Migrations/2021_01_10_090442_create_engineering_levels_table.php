<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEngineeringLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineering_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->tinyInteger('sequence_level')->nullable();
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
        Schema::dropIfExists('engineering_levels');
    }
}
