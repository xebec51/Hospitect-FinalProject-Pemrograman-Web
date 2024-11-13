<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKonsultasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_konsultasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dokter'); // ID Dokter
            $table->unsignedBigInteger('id_pasien'); // ID Pasien
            $table->dateTime('tanggal'); // Tanggal konsultasi
            $table->string('status')->default('scheduled'); // Status (scheduled, completed, canceled, dll.)
            $table->text('catatan')->nullable(); // Catatan konsultasi
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_dokter')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pasien')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_konsultasis');
    }
}
