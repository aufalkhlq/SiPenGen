<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengampu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen');
            $table->json('matkul_id')->constrained('matkul');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD:database/migrations/2024_04_29_091308_create_pengampus_table.php
        Schema::dropIfExists('pengampus');
=======
        Schema::dropIfExists('jam');
>>>>>>> 865f0411564c207fe6f760c8faabef960c74ff14:database/migrations/2024_04_25_075235_add_waktu_table.php
    }
};
