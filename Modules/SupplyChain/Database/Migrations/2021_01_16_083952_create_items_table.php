<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('reorder_stock_level')->nullable();
            $table->integer('taxable')->nullable()->default(1);

            $table->string('category_id')->nullable();
            $table->string('primary_unit_id')->nullable();

            $table->string('sales_coa_id')->nullable();
            $table->string('inventory_coa_id')->nullable();
            $table->string('cost_coa_id')->nullable();
            $table->string('inventory_adjustment_coa_id')->nullable();
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
        Schema::dropIfExists('items');
    }
}
