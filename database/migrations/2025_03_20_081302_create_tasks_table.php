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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade')->nullable();
            $table->string('title');
            $table->text('description');
            $table->date('due_date');
            $table->foreignId('priority_id')->references('id')->on('priorities')->onDelete('cascade');
            $table->integer('points');
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('tasks');
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop foreign key first
        });
    
        Schema::dropIfExists('tasks');
    }
};
