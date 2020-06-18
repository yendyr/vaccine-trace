<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role')
                ->references('id')->on('roles')
                ->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('company')
                ->references('id')->on('companies')
                ->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('updated_by')
                ->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('role');
        });
    }
}
