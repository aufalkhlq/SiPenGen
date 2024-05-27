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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('jam_id');
            $table->unsignedBigInteger('hari_id');
            $table->unsignedBigInteger('kelas_id');
            //pengampu
            $table->unsignedBigInteger('pengampu_id');

            $table->integer('fitness')->default(0);
            $table->timestamps();

            $table->foreign('pengampu_id')->references('id')->on('pengampu')->onDelete('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade');
            $table->foreign('jam_id')->references('id')->on('jam')->onDelete('cascade');
            $table->foreign('hari_id')->references('id')->on('hari')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
