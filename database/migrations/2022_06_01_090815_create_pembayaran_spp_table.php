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
        Schema::create('pembayaran_spp', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran', 10)->unique();
            $table->unsignedBigInteger('santri_id');
            $table->date('tanggal');
            $table->unsignedInteger('jumlah');
            $table->integer('periode_akhir_bayar');
            $table->boolean('batal')->default(false);
            $table->string('user', 20);
            $table->string('user_batal', 20)->nullable();
            $table->text('keterangan_batal')->nullable();
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
        Schema::dropIfExists('pembayaran_spp');
    }
};
