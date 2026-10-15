<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('pandascore_match_id')->unique();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->string('status')->default('pending'); // pending, live, finished, postponed, cancelled
            $table->string('round_label')->nullable();

            // Tim A
            $table->unsignedBigInteger('team_a_id')->nullable();
            $table->string('team_a_name');
            $table->string('team_a_logo')->nullable();
            $table->integer('score_a')->default(0);
            $table->boolean('is_team_a_asia')->default(false);

            // Tim B
            $table->unsignedBigInteger('team_b_id')->nullable();
            $table->string('team_b_name');
            $table->string('team_b_logo')->nullable();
            $table->integer('score_b')->default(0);
            $table->boolean('is_team_b_asia')->default(false);

            $table->boolean('is_asia_match')->default(false);
            $table->string('current_map')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
