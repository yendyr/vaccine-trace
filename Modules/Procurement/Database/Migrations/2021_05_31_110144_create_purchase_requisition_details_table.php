<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequisitionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requisition_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('purchase_requisition_id');

            $table->string('item_id');
            $table->string('coding')->nullable();

            $table->integer('request_quantity')->default(1);
            $table->integer('prepared_to_po_quantity')->default(0);
            $table->integer('processed_to_po_quantity')->default(0);
            $table->integer('prepared_to_grn_quantity')->default(0);
            $table->integer('processed_to_grn_quantity')->default(0);

            $table->string('description')->nullable();
            $table->integer('highlight')->default(0)->nullable();
            $table->string('parent_coding')->nullable();

            $table->rememberToken();
            $table->integer('status')->nullable()->default(1);
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
        Schema::dropIfExists('purchase_requisition_details');
    }
}
