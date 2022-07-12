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
        Schema::create('mapel_asatidz', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->unsignedBigInteger('asatidz_id');
            $table->unsignedBigInteger('mapel_id');
            $table->primary(['asatidz_id', 'mapel_id']);
            $table->string('kode_jadwal', 10)->unique();
            $table->boolean('aktif')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapel_asatidz');
    }
};
