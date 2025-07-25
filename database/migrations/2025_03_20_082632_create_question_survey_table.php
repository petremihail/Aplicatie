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
        Schema::create('question_survey', function (Blueprint $table) {
            $table->foreignId('survey_id')->references('id')->on('surveys')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->references('id')->on('questions')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_survey');
    }
};
