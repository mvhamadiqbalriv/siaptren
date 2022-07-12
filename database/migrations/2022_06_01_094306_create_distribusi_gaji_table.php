<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribusi_gaji', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asatidz_id');
            $table->date('tanggal');
            $table->integer('jumlah_kehadiran');
            $table->integer('upah_pertemuan');
            $table->bigInteger('jumlah_honor');
            $table->timestamps();

            $table->foreign('asatidz_id')->references('id')->on('asatidz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribusi_gaji');
    }
};
