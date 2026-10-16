<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsiaTeam extends Model
{
    use HasFactory;

    protected $table = 'asia_teams';

    protected $fillable = [
        'pandascore_team_id',
        'name',
        'slug',
        'country',
        'region',
        'logo_url',
        'total_prize_money',
        'is_active',
        'valve_ranking', // Tambahkan ini
    ];
}
