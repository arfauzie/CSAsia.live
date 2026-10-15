<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matches()
    {
        return $this->hasMany(MatchModel::class);
    }

    public function bracketNodes()
    {
        return $this->hasMany(BracketNode::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    public function prizeDistributions()
    {
        return $this->hasMany(PrizeDistribution::class);
    }
}
