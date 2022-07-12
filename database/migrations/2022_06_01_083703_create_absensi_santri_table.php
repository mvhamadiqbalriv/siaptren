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
        Schema::create('absensi_santri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('santri_id');
            $table->string('kode_jadwal', 10);
            $table->date('tanggal');
            $table->enum('kehadiran', ['H', 'S', 'I', 'A']);
            $table->text('keterangan')->nullable();
            $table->string('user', 20);
            $table->string('user_update', 20)->nullable();
            $table->timestamps();

            $table->foreign('santri_id')->references('id')->on('santri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_santri');
    }
};
