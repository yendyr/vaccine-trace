<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('workgroup', 4)->unique();
            $table->string('workname', 50)->nullable();
            $table->char('shiftstatus', 1)->comment('Y/N value only');
            $table->string('shiftrolling', 10)->comment('Pola rolling, i.e: 123')->nullable();
            $table->integer('rangerolling')->comment('satuan hari (sekali rolling)')->nullable();
            $table->integer('roundtime')->comment('pembulatan jam kerja (satuan menit)')->nullable();
            $table->smallInteger('workfinger')->comment('finger required for workhour')->nullable();
            $table->smallInteger('restfinger')->comment('finger required for rest')->nullable();
            $table->string('remark', 100)->nullable();

            $table->integer('status')->nullable();
            $table->integer('owned_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
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
        Schema::dropIfExists('working_groups');
    }
}
