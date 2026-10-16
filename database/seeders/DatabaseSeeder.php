<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsiaTeam;
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
        // 1. SEED WHITELIST TIM ASIA (8 TIM ASIA LENGKAP)
        $tyloo = AsiaTeam::updateOrCreate(
            ['pandascore_team_id' => 3213],
            [
                'name' => 'TYLOO',
                'slug' => 'tyloo',
                'country' => 'China',
                'region' => 'East Asia',
                'logo_url' => 'https://cdn.pandascore.co/images/team/image/3213/tyloo_2020.png',
                'total_prize_money' => 64000.00,
                'is_active' => true,
            ]
        );

        $mongolz = AsiaTeam::updateOrCreate(
            ['pandascore_team_id' => 126528],
            [
                'name' => 'The MongolZ',
                'slug' => 'the-mongolz',
                'country' => 'Mongolia',
                'region' => 'East Asia',
                'logo_url' => 'https://cdn.pandascore.co/images/team/image/126528/the_mongolz_2023.png',
                'total_prize_money' => 125000.00,
                'is_active' => true,
            ]
        );

        $alterEgo = AsiaTeam::updateOrCreate(
            ['slug' => 'alter-ego'],
            ['pandascore_team_id' => 4001, 'name' => 'Alter Ego', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'logo_url' => 'https://via.placeholder.com/80?text=AE', 'is_active' => true]
        );

        $lynnVision = AsiaTeam::updateOrCreate(
            ['slug' => 'lynn-vision'],
            ['pandascore_team_id' => 4002, 'name' => 'Lynn Vision', 'country' => 'China', 'region' => 'East Asia', 'logo_url' => 'https://via.placeholder.com/80?text=LV', 'is_active' => true]
        );

        $rareAtom = AsiaTeam::updateOrCreate(
            ['slug' => 'rare-atom'],
            ['pandascore_team_id' => 4003, 'name' => 'Rare Atom', 'country' => 'China', 'region' => 'East Asia', 'logo_url' => 'https://via.placeholder.com/80?text=RA', 'is_active' => true]
        );

        $justWing = AsiaTeam::updateOrCreate(
            ['slug' => 'just-wing'],
            ['pandascore_team_id' => 4004, 'name' => 'Just Wing', 'country' => 'Asia', 'region' => 'Asia', 'logo_url' => 'https://via.placeholder.com/80?text=JW', 'is_active' => true]
        );

        $flyQuest = AsiaTeam::updateOrCreate(
            ['slug' => 'flyquest'],
            ['pandascore_team_id' => 4005, 'name' => 'FlyQuest', 'country' => 'Australia', 'region' => 'Asia-Pacific', 'logo_url' => 'https://via.placeholder.com/80?text=FQ', 'is_active' => true]
        );

        $nexVoid = AsiaTeam::updateOrCreate(
            ['slug' => 'nexvoid'],
            ['pandascore_team_id' => 4006, 'name' => 'NexVoid', 'country' => 'Asia', 'region' => 'Asia', 'logo_url' => 'https://via.placeholder.com/80?text=NV', 'is_active' => true]
        );

        // Seed Roster untuk TYLOO
        if ($tyloo->rosters()->count() == 0) {
            $tyloo->rosters()->createMany([
                ['nickname' => 'JamYoung', 'full_name' => 'Yifei Li', 'role' => 'player', 'rating' => 6.4],
                ['nickname' => 'Jee', 'full_name' => 'Qinghui Ji', 'role' => 'player', 'rating' => 6.0],
                ['nickname' => 'Mercury', 'full_name' => 'Jingxiang Wang', 'role' => 'player', 'rating' => 6.0],
                ['nickname' => 'Moseyuh', 'full_name' => 'Zhaohui Wang', 'role' => 'player', 'rating' => 6.0],
                ['nickname' => 'Zero', 'full_name' => 'Zhihao Huang', 'role' => 'player', 'rating' => 6.0],
            ]);
        }


        // 2. TURNAMEN 1: ESL Pro League Season 24 (Tier S - Ongoing)
        $esl = Tournament::updateOrCreate(
            ['slug' => 'esl-pro-league-season-24'],
            [
                'pandascore_tournament_id' => 't-esl-pro-24',
                'name' => 'ESL Pro League Season 24',
                'tier' => 'S',
                'status' => 'ongoing',
                'start_date' => Carbon::now()->subDays(3),
                'end_date' => Carbon::now()->addDays(7),
                'asia_team_count' => 2,
                'prize_pool' => 1000000.00,
                'image_url' => 'https://cdn.pandascore.co/images/tournament/image/1234/esl.png',
            ]
        );

        // Match ESL Live & Finished
        $matchEslLive = MatchModel::updateOrCreate(
            ['pandascore_match_id' => 'm-esl-live-01'],
            [
                'tournament_id' => $esl->id,
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
            ]
        );

        MatchModel::updateOrCreate(
            ['pandascore_match_id' => 'm-esl-fin-01'],
            [
                'tournament_id' => $esl->id,
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
            ]
        );

        // ESL Bracket & Prize
        BracketNode::updateOrCreate(
            ['tournament_id' => $esl->id, 'round_label' => 'Group Stage', 'team_a_name' => 'TYLOO'],
            ['match_id' => $matchEslLive->id, 'team_b_name' => 'M80', 'score_a' => 1, 'score_b' => 1, 'is_clickable' => true]
        );
        Standing::updateOrCreate(['tournament_id' => $esl->id, 'team_name' => 'TYLOO'], ['record' => '1-1', 'position' => 3]);
        Standing::updateOrCreate(['tournament_id' => $esl->id, 'team_name' => 'Vitality'], ['record' => '3-0', 'position' => 1]);
        PrizeDistribution::updateOrCreate(['tournament_id' => $esl->id, 'placement' => '1st Place'], ['amount' => '$500,000', 'team_name' => 'Vitality']);


        // 3. TURNAMEN 2: MaceMedia VOID Autumn Cup 2026 (Tier A - Ongoing + MATCH LIVE & DETAIL LENGKAP)
        $voidCup = Tournament::updateOrCreate(
            ['slug' => 'macemedia-void-autumn-cup-2026'],
            [
                'pandascore_tournament_id' => 't-void-autumn-26',
                'name' => 'MaceMedia VOID Autumn Cup 2026',
                'tier' => 'A',
                'status' => 'ongoing',
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(5),
                'asia_team_count' => 6,
                'prize_pool' => 250000.00,
                'image_url' => 'https://via.placeholder.com/150?text=VOID',
            ]
        );

        // Match LIVE untuk VOID Autumn Cup (Agar Muncul di Beranda Kolom Kiri!)
        $matchVoidLive = MatchModel::updateOrCreate(
            ['pandascore_match_id' => 'm-void-live-01'],
            [
                'tournament_id' => $voidCup->id,
                'start_time' => Carbon::now()->subMinutes(15),
                'status' => 'live',
                'round_label' => 'Group Stage - Opening Match',
                'team_a_id' => $alterEgo->pandascore_team_id,
                'team_a_name' => 'Alter Ego',
                'team_a_logo' => $alterEgo->logo_url,
                'score_a' => 1,
                'is_team_a_asia' => true,
                'team_b_id' => $lynnVision->pandascore_team_id,
                'team_b_name' => 'Lynn Vision',
                'team_b_logo' => $lynnVision->logo_url,
                'score_b' => 0,
                'is_team_b_asia' => true,
                'is_asia_match' => true,
                'current_map' => 'Inferno (Map 2)',
            ]
        );

        MatchModel::updateOrCreate(
            ['pandascore_match_id' => 'm-void-upcoming-01'],
            [
                'tournament_id' => $voidCup->id,
                'start_time' => Carbon::now()->addHours(2),
                'status' => 'upcoming',
                'round_label' => 'Group Stage - Match 2',
                'team_a_id' => $mongolz->pandascore_team_id,
                'team_a_name' => 'The MongolZ',
                'team_a_logo' => $mongolz->logo_url,
                'score_a' => 0,
                'is_team_a_asia' => true,
                'team_b_id' => $rareAtom->pandascore_team_id,
                'team_b_name' => 'Rare Atom',
                'team_b_logo' => $rareAtom->logo_url,
                'score_b' => 0,
                'is_team_b_asia' => true,
                'is_asia_match' => true,
            ]
        );

        // Bracket Nodes untuk VOID Cup
        BracketNode::updateOrCreate(
            ['tournament_id' => $voidCup->id, 'round_label' => 'Group Stage', 'team_a_name' => 'Alter Ego'],
            ['match_id' => $matchVoidLive->id, 'team_b_name' => 'Lynn Vision', 'score_a' => 1, 'score_b' => 0, 'is_clickable' => true]
        );

        BracketNode::updateOrCreate(
            ['tournament_id' => $voidCup->id, 'round_label' => 'Playoffs Semi Final', 'team_a_name' => 'The MongolZ'],
            ['match_id' => null, 'team_b_name' => 'Rare Atom', 'score_a' => 0, 'score_b' => 0, 'is_clickable' => true]
        );

        // Standings (6 Peserta Asia untuk VOID Cup)
        $voidTeams = ['Alter Ego', 'Lynn Vision', 'The MongolZ', 'Rare Atom', 'Just Wing', 'FlyQuest'];
        foreach ($voidTeams as $index => $teamName) {
            Standing::updateOrCreate(
                ['tournament_id' => $voidCup->id, 'team_name' => $teamName],
                ['record' => '0-0', 'position' => $index + 1]
            );
        }

        // Prize Distribution VOID Cup
        PrizeDistribution::updateOrCreate(['tournament_id' => $voidCup->id, 'placement' => '1st Place'], ['amount' => '$100,000', 'team_name' => null]);
        PrizeDistribution::updateOrCreate(['tournament_id' => $voidCup->id, 'placement' => '2nd Place'], ['amount' => '$50,000', 'team_name' => null]);
        PrizeDistribution::updateOrCreate(['tournament_id' => $voidCup->id, 'placement' => '3rd - 4th'], ['amount' => '$25,000', 'team_name' => null]);


        // 4. TURNAMEN 3: DFRAG Invitational 2026 (Tier B - Upcoming)
        Tournament::updateOrCreate(
            ['slug' => 'dfrag-invitational-2026'],
            [
                'pandascore_tournament_id' => 't-dfrag-inv-26',
                'name' => 'DFRAG Invitational 2026',
                'tier' => 'B',
                'status' => 'upcoming',
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addDays(10),
                'asia_team_count' => 4,
                'prize_pool' => 100000.00,
                'image_url' => 'https://via.placeholder.com/150?text=DFRAG',
            ]
        );
    }
}
