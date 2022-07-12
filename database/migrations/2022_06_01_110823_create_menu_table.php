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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu', 50);
            $table->string('url', 100);
            $table->string('icon', 50)->nullable();
            $table->string('jenis', 30)->nullable();
            $table->integer('main_menu')->nullable();
            $table->integer('no_urut')->default(0);
            $table->timestamps();

            $table->unique(['nama_menu', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
