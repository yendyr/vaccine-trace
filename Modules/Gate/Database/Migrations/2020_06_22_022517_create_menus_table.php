<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('menu_class')->comment('Class to determine if user able to view this menu')->nullable();
            $table->string('group')->nullable()->comment('grouping menu per module/group');
            $table->unsignedInteger('parent_id')->nullable()->comment('recursive relationship');
            $table->string('menu_text');
            $table->string('menu_link')->default('#');
            $table->string('menu_route')->nullable();
            $table->string('menu_icon')->default('fa-minus');
            $table->string('menu_id')->nullable();
            $table->integer('add');
            $table->integer('update');
            $table->integer('delete');
            $table->integer('print');
            $table->tinyInteger('approval');
            $table->tinyInteger('process');
            $table->json('menu_actives')->nullable();

            $table->integer('status')->nullable();
            $table->integer('owned_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
