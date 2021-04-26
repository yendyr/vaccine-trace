<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('code')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('csn')->nullable();
            $table->string('cso')->nullable();
            $table->string('tsn')->nullable();
            $table->string('tso')->nullable();
            $table->string('aircraft_id')->nullable();
            $table->string('aircraft_registration_number');
            $table->string('aircraft_serial_number')->nullable();
            $table->string('station')->nullable();
            $table->string('description')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('file_attachment')->nullable();
            
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
        Schema::dropIfExists('work_orders');
    }
}
