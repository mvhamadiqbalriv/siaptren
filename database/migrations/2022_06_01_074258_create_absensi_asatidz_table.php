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
        Schema::create('absensi_asatidz', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jadwal', 10);
            $table->dateTime('tanggal');
            $table->unsignedBigInteger('asatidz_id');
            $table->enum('kehadiran', ['H', 'S', 'I', 'A']);
            $table->text('keterangan')->nullable();
            $table->string('user', 20);
            $table->string('user_update', 20)->nullable();
            $table->dateTime('waktu_update')->nullable();

            // $table->foreign('kode_jadwal')->references('kode_jadwal')->on('mapel_asatidz');
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
        Schema::dropIfExists('absensi_asatidz');
    }
};
