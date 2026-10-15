<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('pandascore_tournament_id')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tier'); // S, A, B, C
            $table->string('status'); // upcoming, ongoing, finished
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('asia_team_count')->default(0);
            $table->decimal('prize_pool', 12, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
