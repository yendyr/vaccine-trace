<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('item_id');
            $table->string('serial_number')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('detailed_item_location')->nullable();

            $table->string('inbound_mutation_id')->nullable();

            $table->string('coding')->nullable();

            $table->double('each_price_before_vat')->default(0);
            $table->integer('quantity')->default(1);
            $table->integer('used_quantity')->default(0);
            $table->integer('loaned_quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);

            $table->string('alias_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('highlight')->default(0)->nullable();
            $table->string('parent_coding')->nullable();

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
        Schema::dropIfExists('item_stocks_table');
    }
}
