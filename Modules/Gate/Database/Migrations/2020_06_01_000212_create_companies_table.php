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
        Schema::create('companies', function (Blueprint $table) {   //code, company, name, email, remark, kolom wajib, standard laravel
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('email')->unique();

            $table->string('remark')->nullable();
            $table->integer('status')->nullable();
            $table->string('owned_by')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
