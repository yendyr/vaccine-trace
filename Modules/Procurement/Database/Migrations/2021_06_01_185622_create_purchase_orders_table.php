<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('code')->nullable();
            $table->date('transaction_date');
            $table->date('valid_until_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('supplier_id');
            $table->string('description')->nullable();
            $table->string('term_and_condition')->nullable();

            $table->string('current_primary_currency_id');
            $table->string('currency_id');
            $table->double('exchange_rate')->default(1);

            $table->string('transaction_reference_id')->nullable();
            $table->string('transaction_reference_class')->default('\Modules\Procurement\Entities\PurchaseRequisition');
            $table->string('transaction_reference_text')->default('Purchase Requisition');
            $table->string('transaction_reference_url')->nullable();

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
        Schema::dropIfExists('purchase_orders');
    }
}
