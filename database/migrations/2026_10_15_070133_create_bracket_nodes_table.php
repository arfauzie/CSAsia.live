<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bracket_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->unsignedBigInteger('match_id')->nullable(); // Definisikan manual dulu agar aman
            $table->foreign('match_id')->references('id')->on('matches')->nullOnDelete();
            $table->string('round_label');
            $table->string('team_a_name');
            $table->string('team_b_name');
            $table->integer('score_a')->nullable();
            $table->integer('score_b')->nullable();
            $table->boolean('is_clickable')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bracket_nodes');
    }
};
