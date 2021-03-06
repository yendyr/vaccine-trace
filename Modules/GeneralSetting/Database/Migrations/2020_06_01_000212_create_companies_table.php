<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {  
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('npwp_number')->nullable();
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_alternative')->nullable();

            $table->string('is_customer')->default('1')->nullable();
            $table->string('is_supplier')->default('1')->nullable();
            $table->string('is_manufacturer')->default('1')->nullable();

            $table->string('account_receivable_coa_id')->nullable();
            $table->string('sales_discount_coa_id')->nullable();

            $table->string('account_payable_coa_id')->nullable();
            $table->string('purchase_discount_coa_id')->nullable();

            $table->rememberToken();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
