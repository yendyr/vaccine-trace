<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWOWPTaskcardDetailItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_wp_taskcard_detail_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('work_order_id')->nullable();
            $table->string('work_package_id')->nullable();
            $table->string('taskcard_id')->nullable();
            $table->string('detail_id')->nullable();
            $table->string('item_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('unit_id')->nullable();
            $table->string('description')->nullable();

            $table->json('item_json')->nullable();
            $table->json('unit_json')->nullable();
            $table->json('taskcard_json')->nullable();
            
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
        Schema::dropIfExists('w_o_w_p_taskcard_items');
    }
}
