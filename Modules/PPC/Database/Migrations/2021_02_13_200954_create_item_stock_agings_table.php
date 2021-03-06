<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStockAgingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_stock_agings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('item_stock_id');

            $table->string('transaction_reference_id');
            $table->string('transaction_reference_class');
            $table->string('transaction_reference_text');
            $table->string('transaction_reference_url');

            $table->double('flight_hour')->nullable()->default(0);
            $table->double('block_hour')->nullable()->default(0);
            $table->integer('flight_cycle')->nullable()->default(0);
            $table->integer('flight_event')->nullable()->default(0);

            $table->string('description')->nullable();
            
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
        Schema::dropIfExists('item_stocks_agings');
    }
}
