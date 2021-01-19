<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->char('iso', 2)->nullable();
            $table->char('iso_3', 3  )->nullable();
            $table->string('name', 80)->nullable();
            $table->string('nice_name', 80)->nullable();
            $table->smallinteger('num_code')->nullable();
            $table->integer('phone_code')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
