<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderWorkPackageTaskcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_work_package_taskcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            
            $table->string('work_order_id');
            $table->string('work_package_id');
            $table->string('taskcard_id');
            $table->string('description');

            $table->json('taskcard_json')->nullable();
            $table->json('taskcard_group_json')->nullable();
            $table->json('taskcard_type_json')->nullable();
            $table->json('taskcard_workarea_json')->nullable();
            $table->json('aircraft_types_json')->nullable();
            $table->json('aircraft_type_details_json')->nullable();
            $table->json('affected_items_json')->nullable();
            $table->json('affected_item_details_json')->nullable();
            $table->json('tags_json')->nullable();
            $table->json('tag_details_json')->nullable();
            $table->json('accesses_json')->nullable();
            $table->json('access_details_json')->nullable();
            $table->json('zones_json')->nullable();
            $table->json('zone_details_json')->nullable();
            $table->json('document_libraries_json')->nullable();
            $table->json('document_library_details_json')->nullable();
            $table->json('affected_manuals_json')->nullable();
            $table->json('affected_manual_details_json')->nullable();
            $table->json('instruction_details_json')->nullable();
            $table->json('items_json')->nullable();
            $table->json('item_details_json')->nullable();

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
        Schema::dropIfExists('work_order_work_package_taskcards');
    }
}
