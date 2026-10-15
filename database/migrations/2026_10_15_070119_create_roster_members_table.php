<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roster_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asia_team_id')->constrained('asia_teams')->onDelete('cascade');
            $table->string('nickname');
            $table->string('full_name')->nullable();
            $table->string('role')->default('player'); // player, coach, stand-in
            $table->string('photo_url')->nullable();
            $table->decimal('rating', 3, 1)->default(0.0); // Contoh rating pemain (misal: 6.4)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roster_members');
    }
};
