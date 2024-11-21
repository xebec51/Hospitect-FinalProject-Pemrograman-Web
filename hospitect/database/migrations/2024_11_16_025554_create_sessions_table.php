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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID unik untuk sesi
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Opsional, mengacu ke tabel 'users'
            $table->string('ip_address', 45)->nullable(); // Alamat IP pengguna
            $table->text('user_agent')->nullable(); // Informasi agen pengguna (browser)
            $table->text('payload'); // Data sesi
            $table->integer('last_activity')->unsigned(); // Aktivitas terakhir dalam sesi

            $table->timestamps(); // Menambahkan kolom created_at dan updated_at (opsional)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
