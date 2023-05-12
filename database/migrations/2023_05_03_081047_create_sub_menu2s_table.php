<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubMenu2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_menu2s', function (Blueprint $table) {
            $table->id();
            $table->string('caption', 40);
            $table->string('route_name', 40);
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('sub_menus');
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
        Schema::dropIfExists('sub_menu2s');
    }
}
