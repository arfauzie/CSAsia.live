<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'int';    // Sesuaikan jika ID PandaScore berupa integer (atau 'string' jika berupa string)
    public $incrementing = false;  // Wajib false karena ID menggunakan dari PandaScore, bukan auto-increment lokal

    // Relasi ke Match
    public function matches()
    {
        return $this->hasMany(MatchModel::class);
    }

    // Relasi ke Bracket Node
    public function bracketNodes()
    {
        return $this->hasMany(BracketNode::class);
    }

    // Relasi ke Standings
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    // Relasi ke Prize Distribution
    public function prizeDistributions()
    {
        return $this->hasMany(PrizeDistribution::class);
    }

    // Tambahan relasi Many-to-Many ke Tim Asia (untuk pivot table turnamen & tim)
    public function teams()
    {
        return $this->belongsToMany(AsiaTeam::class, 'tournament_team', 'tournament_id', 'team_id');
    }
}
