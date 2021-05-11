<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWOWPTaskcardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_wp_taskcard_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('work_order_id')->nullable();
            $table->string('work_package_id')->nullable();
            $table->string('taskcard_id')->nullable();
            
            $table->tinyInteger('sequence')->nullable();
            $table->string('instruction_code')->nullable();
            $table->string('taskcard_workarea_id')->nullable();
            $table->double('manhours_estimation')->default(0);
            $table->double('performance_factor');
            $table->string('engineering_level_id'); // set minimum authorized engineering level to execute this taskcard
            $table->tinyInteger('manpower_quantity');
            $table->string('task_release_level_id');
            $table->string('instruction', 2000)->nullable();
            $table->string('transaction_status')->nullable();
            $table->json('skills_json')->nullable();
            $table->json('taskcard_workarea_json')->nullable();
            $table->json('engineering_level_json')->nullable();
            $table->json('task_release_level_json')->nullable();
            $table->string('is_exec_all')->nullable();

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
        Schema::dropIfExists('w_o_w_p_taskcard_details');
    }
}
