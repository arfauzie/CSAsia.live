<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'finished_at' => 'datetime',
        'is_team_a_asia' => 'boolean',
        'is_team_b_asia' => 'boolean',
        'is_asia_match' => 'boolean',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function bracketNode()
    {
        return $this->hasOne(BracketNode::class, 'match_id');
    }
}
