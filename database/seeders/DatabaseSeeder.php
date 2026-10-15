<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsiaTeam;
use App\Models\RosterMember;
use App\Models\Tournament;
use App\Models\MatchModel;
use App\Models\BracketNode;
use App\Models\Standing;
use App\Models\PrizeDistribution;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Whitelist Tim Asia
        $tyloo = AsiaTeam::create([
            'pandascore_team_id' => 3213,
            'name' => 'TYLOO',
            'slug' => 'tyloo',
            'country' => 'China',
            'region' => 'East Asia',
            'logo_url' => 'https://cdn.pandascore.co/images/team/image/3213/tyloo_2020.png',
            'total_prize_money' => 64000.00,
            'is_active' => true,
        ]);

        $mongolz = AsiaTeam::create([
            'pandascore_team_id' => 126528,
            'name' => 'The MongolZ',
            'slug' => 'the-mongolz',
            'country' => 'Mongolia',
            'region' => 'East Asia',
            'logo_url' => 'https://cdn.pandascore.co/images/team/image/126528/the_mongolz_2023.png',
            'total_prize_money' => 125000.00,
            'is_active' => true,
        ]);

        // 2. Seed Roster Pemain untuk TYLOO
        $tyloo->rosters()->createMany([
            ['nickname' => 'JamYoung', 'full_name' => 'Yifei Li', 'role' => 'player', 'rating' => 6.4],
            ['nickname' => 'Jee', 'full_name' => 'Qinghui Ji', 'role' => 'player', 'rating' => 6.0],
            ['nickname' => 'Mercury', 'full_name' => 'Jingxiang Wang', 'role' => 'player', 'rating' => 6.0],
            ['nickname' => 'Moseyuh', 'full_name' => 'Zhaohui Wang', 'role' => 'player', 'rating' => 6.0],
            ['nickname' => 'Zero', 'full_name' => 'Zhihao Huang', 'role' => 'player', 'rating' => 6.0],
        ]);

        // 3. Seed Turnamen (Tier S - Ongoing)
        $tournament = Tournament::create([
            'pandascore_tournament_id' => 't-esl-pro-24',
            'name' => 'ESL Pro League Season 24',
            'slug' => 'esl-pro-league-season-24',
            'tier' => 'S',
            'status' => 'ongoing',
            'start_date' => Carbon::now()->subDays(3),
            'end_date' => Carbon::now()->addDays(7),
            'asia_team_count' => 2,
            'prize_pool' => 1000000.00,
            'image_url' => 'https://cdn.pandascore.co/images/tournament/image/1234/esl.png',
        ]);

        // 4. Seed Match LIVE (Melibatkan Tim Asia: TYLOO vs M80)
        $matchLive = MatchModel::create([
            'pandascore_match_id' => 'm-live-01',
            'tournament_id' => $tournament->id,
            'start_time' => Carbon::now()->subMinutes(30),
            'status' => 'live',
            'round_label' => 'Group Stage - Round 1',
            'team_a_id' => $tyloo->pandascore_team_id,
            'team_a_name' => 'TYLOO',
            'team_a_logo' => $tyloo->logo_url,
            'score_a' => 1,
            'is_team_a_asia' => true,
            'team_b_id' => 9999,
            'team_b_name' => 'M80',
            'team_b_logo' => 'https://cdn.pandascore.co/images/team/image/9999/m80.png',
            'score_b' => 1,
            'is_team_b_asia' => false,
            'is_asia_match' => true,
            'current_map' => 'Mirage (Map 3)',
        ]);

        // 5. Seed Match Finished (Arsip / Recent Match untuk Detail Tim)
        MatchModel::create([
            'pandascore_match_id' => 'm-fin-01',
            'tournament_id' => $tournament->id,
            'start_time' => Carbon::now()->subDays(1),
            'status' => 'finished',
            'round_label' => 'Group Stage',
            'team_a_id' => $tyloo->pandascore_team_id,
            'team_a_name' => 'TYLOO',
            'team_a_logo' => $tyloo->logo_url,
            'score_a' => 1,
            'is_team_a_asia' => true,
            'team_b_id' => 8888,
            'team_b_name' => '9z Team',
            'team_b_logo' => 'https://cdn.pandascore.co/images/team/image/8888/9z.png',
            'score_b' => 2,
            'is_team_b_asia' => false,
            'is_asia_match' => true,
            'finished_at' => Carbon::now()->subHours(18),
        ]);

        // 6. Seed Bracket Nodes (Menguji node Asia & non-Asia abu-abu)
        // Node 1: Match Asia (Bisa diklik)
        BracketNode::create([
            'tournament_id' => $tournament->id,
            'match_id' => $matchLive->id,
            'round_label' => 'Group Stage',
            'team_a_name' => 'TYLOO',
            'team_b_name' => 'M80',
            'score_a' => 1,
            'score_b' => 1,
            'is_clickable' => true,
        ]);

        // Node 2: Match Non-Asia (Teks statis abu-abu, unclickable)
        BracketNode::create([
            'tournament_id' => $tournament->id,
            'match_id' => null,
            'round_label' => 'Playoffs Quarterfinal',
            'team_a_name' => 'FaZe Clan',
            'team_b_name' => 'Natus Vincere',
            'score_a' => 2,
            'score_b' => 0,
            'is_clickable' => false,
        ]);

        // 7. Standings & Prize Distribution
        Standing::create([
            'tournament_id' => $tournament->id,
            'team_name' => 'TYLOO',
            'record' => '1-1',
            'position' => 3,
        ]);

        PrizeDistribution::create([
            'tournament_id' => $tournament->id,
            'placement' => '1st Place',
            'amount' => '$500,000',
        ]);
    }
}
