<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asia_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pandascore_team_id')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('country')->nullable();
            $table->string('region')->default('Asia'); // East Asia, Southeast Asia, dll
            $table->string('logo_url')->nullable();
            $table->decimal('total_prize_money', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asia_teams');
    }
};
