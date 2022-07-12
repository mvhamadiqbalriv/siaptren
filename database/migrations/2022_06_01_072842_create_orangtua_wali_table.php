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
        Schema::create('orangtua_wali', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('santri_id');
            $table->string('nama', 50);
            $table->string('pekerjaan', 100);
            $table->string('nomor_handphone', 15);
            $table->text('alamat');
            $table->enum('status_keluarga', ['Ayah', 'Ibu', 'Wali']);

            $table->foreign('santri_id')->references('id')->on('santri')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orangtua_wali');
    }
};
