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
        Schema::create('asatidz', function (Blueprint $table) {
            $table->id();
            $table->string('kode_asatidz', 10)->unique();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap', 50);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir', 50);
            $table->integer('upah_pertemuan');
            $table->boolean('aktif')->default(true);
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
        Schema::dropIfExists('asatidz');
    }
};
