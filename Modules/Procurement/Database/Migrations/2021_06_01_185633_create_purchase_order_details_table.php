<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('purchase_order_id');
            $table->string('purchase_requisition_detail_id')->nullable();

            $table->integer('order_quantity')->default(1);

            $table->date('required_delivery_date')->nullable();
            $table->string('description')->nullable();

            $table->double('vat')->default(0);
            $table->double('each_price_before_vat')->default(0);

            $table->integer('prepared_to_grn_quantity')->default(0);
            $table->integer('processed_to_grn_quantity')->default(0);

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
        Schema::dropIfExists('purchase_order_details');
    }
}
