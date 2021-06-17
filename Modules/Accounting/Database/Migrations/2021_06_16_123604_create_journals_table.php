<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            
            $table->string('code')->unique()->nullable();
            $table->date('transaction_date');
            $table->date('document_date')->nullable();
            $table->date('event_date')->nullable();
            $table->string('description')->nullable();

            $table->string('current_primary_currency_id');
            $table->string('currency_id');
            $table->double('exchange_rate')->default(1);

            $table->string('transaction_reference_id')->nullable();
            $table->string('transaction_reference_class')->nullable();
            $table->string('transaction_reference_text')->nullable();
            $table->string('transaction_reference_url')->nullable();

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
        Schema::dropIfExists('journals');
    }
}
