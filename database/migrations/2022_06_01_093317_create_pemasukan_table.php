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
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pemasukan', 50);
            $table->unsignedInteger('jumlah');
            $table->text('keterangan');
            $table->string('user', 20);
            $table->boolean('batal')->default(false);
            $table->string('user_batal', 20)->nullable();
            $table->text('keterangan_batal')->nullable();
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
        Schema::dropIfExists('pemasukan');
    }
};
