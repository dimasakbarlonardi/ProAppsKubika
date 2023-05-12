<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('nama_site', 30);
            $table->string('alamat', 50);
            $table->string('kode_pos', 7);
            $table->string('no_telp1', 15);
            $table->string('no_telp2', 15)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('fb', 20)->nullable();
            $table->string('ig', 20)->nullable();
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
        Schema::dropIfExists('sites');
    }
}
