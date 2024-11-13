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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('id_obat');
            $table->string('nama_obat');
            $table->text('deskripsi')->nullable();
            $table->string('jenis_obat');
            $table->integer('stok');
            $table->string('gambar_obat')->nullable(); // Jalur file gambar jika ada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
