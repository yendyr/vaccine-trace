<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDetailContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_detail_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('label')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('office_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('other_number')->nullable();
            $table->string('website')->nullable();
            $table->string('website_alternative')->nullable();
            $table->string('description')->nullable();

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
        Schema::dropIfExists('company_detail_contacts');
    }
}
