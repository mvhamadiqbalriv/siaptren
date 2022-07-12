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
        Schema::create('tunggakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri');
            $table->integer('periode_awal_bayar');
            $table->integer('periode_akhir_bayar');
            $table->integer('periode_tunggakan');
            $table->integer('tunggakan');
            $table->integer('sisa_bayar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tunggakan');
    }
};
