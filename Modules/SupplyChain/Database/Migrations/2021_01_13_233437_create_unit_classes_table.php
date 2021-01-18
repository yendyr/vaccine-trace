<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->rememberToken();

            $table->integer('status')->nullable();
            $table->integer('owned_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_classes');
    }
}
