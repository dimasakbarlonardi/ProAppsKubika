<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_site')->nullable();
            $table->foreign('id_site')->references('id')->on('sites');
            $table->unsignedBigInteger('id_status_user')->nullable();
            $table->foreign('id_status_user')->references('id')->on('status_users');
            $table->unsignedBigInteger('id_role')->nullable();
            $table->foreign('id_role')->references('id')->on('roles');
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
            //
        });
    }
}
