<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('id_umpan_balik');
            $table->foreignId('id_jadwal')->constrained('appointments', 'id_jadwal')->onDelete('cascade');
            $table->foreignId('id_pasien')->constrained('users')->onDelete('cascade');
            $table->integer('penilaian');
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
