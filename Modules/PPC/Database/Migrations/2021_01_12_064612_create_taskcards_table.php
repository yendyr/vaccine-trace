<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('mpd_number');
            $table->string('title');
            $table->string('taskcard_group_id');
            $table->string('taskcard_type_id');
            $table->string('compliance')->default('Optional');

            $table->integer('on_condition')->nullable();
            $table->string('threshold_flight_hour')->nullable();
            $table->string('threshold_flight_cycle')->nullable();
            $table->string('threshold_daily')->nullable();
            $table->string('threshold_daily_unit')->default('Year');
            $table->date('threshold_date')->nullable();
            $table->string('repeat_flight_hour')->nullable();
            $table->string('repeat_flight_cycle')->nullable();
            $table->string('repeat_daily')->nullable();
            $table->string('repeat_daily_unit')->default('Year');
            $table->date('repeat_date')->nullable();
            $table->string('interval_control_method')->default('Which One Comes First');
            
            $table->string('company_number')->nullable();
            $table->string('ata')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('version')->nullable();
            $table->string('position')->nullable();
            $table->string('revision')->nullable();
            $table->string('effectivity')->nullable();
            $table->string('taskcard_workarea_id')->nullable();
            $table->string('source')->nullable();
            $table->string('reference')->nullable();
            $table->string('file_attachment')->nullable();
            $table->string('scheduled_priority')->default('As Scheduled');
            $table->string('recurrence')->default('As Required');
            
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
        Schema::dropIfExists('taskcards');
    }
}
