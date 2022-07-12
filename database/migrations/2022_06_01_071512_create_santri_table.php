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
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            $table->string('kode_santri', 9)->unique();
            $table->string('nama_lengkap', 50);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir', 50);
            $table->string('universitas', 100);
            $table->string('fakultas', 100);
            $table->string('prodi', 100);
            $table->integer('semester');
            $table->string('nomor_handphone', 15);
            $table->text('alamat');
            $table->string('email', 100)->unique();
            $table->enum('status', ['Aktif', 'Lulus'])->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->year('tahun_masuk');
            $table->year('tahun_lulus')->nullable();
            $table->string('user_update', 20)->nullable();
            $table->string('user_verifikasi', 20)->nullable();
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
        Schema::dropIfExists('santri');
    }
};
