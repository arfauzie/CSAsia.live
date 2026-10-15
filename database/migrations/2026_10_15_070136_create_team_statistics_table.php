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
        Schema::create('team_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asia_team_id')->constrained('asia_teams')->onDelete('cascade');
            $table->string('category'); // cth: "Tournaments", "Matches", "Maps", "Rounds"
            $table->integer('count_value')->default(0);
            $table->decimal('win_rate', 5, 2)->default(0.00); // cth: 55.00 (%)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_statistics');
    }
};
