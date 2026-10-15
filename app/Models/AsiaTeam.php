<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsiaTeam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rosters()
    {
        return $this->hasMany(RosterMember::class);
    }

    public function statistics()
    {
        return $this->hasMany(TeamStatistic::class);
    }
}
