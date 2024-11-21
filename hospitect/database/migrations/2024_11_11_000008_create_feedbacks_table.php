<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('appointment_id')
                  ->constrained('appointments')
                  ->onDelete('cascade'); // Relasi ke appointments
            $table->foreignId('patient_id')
                  ->constrained('patients')
                  ->onDelete('cascade'); // Relasi ke patients
            $table->unsignedTinyInteger('rating')->comment('Rating between 1-5'); // Rating (1-5)
            $table->text('comment')->nullable()->comment('Feedback comment'); // Komentar opsional
            $table->timestamps(); // Waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
}
