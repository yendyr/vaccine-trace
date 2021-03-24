<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskcardDetailInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskcard_detail_instructions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('taskcard_id');
            $table->tinyInteger('sequence')->nullable();
            $table->string('taskcard_workarea_id')->nullable();
            $table->string('instruction_code')->nullable();
            $table->double('manhours_estimation')->default(0);
            $table->double('performance_factor');
            $table->string('engineering_level_id'); // set minimum authorized engineering level to execute this taskcard
            $table->tinyInteger('manpower_quantity');
            $table->string('task_release_level_id');
            $table->string('instruction')->nullable();

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
        Schema::dropIfExists('taskcard_detail_instructions');
    }
}
