<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\AsiaTeam;

class TeamSyncService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.pandascore.co/csgo/teams';

    public function __construct()
    {
        $this->apiKey = env('PANDASCORE_API_KEY');
    }

    public function autoDiscoverAndSyncAsiaTeams()
    {
        // 1. Whitelist Nama Tim Resmi Valve Asia (Berdasarkan Ranking HLTV / Valve Regional Standings)
        $valveAsiaTeamsWhitelist = [
            'BC.GAME',
            'TYLOO',
            'THE MONGOLZ',
            'CHINGGIS WARRIORS',
            'FLYQUEST',
            '5STAR',
            'LYNN VISION',
            'NEXVOID',
            'DEPO',
            'GROUND ZERO',
            'THUNDER DOWNUNDER',
            'THE HUNS',
            'ABYSSAL',
            'ALTER EGO',
            'ROOSTER',
            'RARE ATOM',
            'KALEIDO',
            'JUST SWING',
            'KZG',
            'VITALEM AEREM',
            'MINDFREAK',
            'THE UNIT',
            'NAS',
            '5DADS',
            'REVENGE',
            'MARKANDLARRY',
            'HAUNTED HOUSE',
            'LFO 8',
            'XDM',
            'EX-ARCADE',
            'THE KNOCKOUTX',
            'LFO 9',
            'DING CUTS',
            'BGNS ORANGE',
            'MADLIKEWIZARDS',
            'LEGION',
            'SEMPERFI',
            'BORING PLAYERS',
            'FRUJU',
            'FURY',
            'BANZAI',
            '1337',
            'BLIGHT BLUE',
            'QUANTUMX'
        ];

        // 2. Daftar Negara & Label Wilayah Spesifik Pilihanmu
        $allowedLocations = [
            'CN',
            'MN',
            'AU',
            'KG',
            'PK',
            'UZ',
            'KZ',
            'CHINA',
            'MONGOLIA',
            'AUSTRALIA',
            'KYRGYZSTAN',
            'PAKISTAN',
            'UZBEKISTAN',
            'KAZAKHSTAN',
            'ASIA',
            'ASIA-PACIFIC'
        ];

        $syncedCount = 0;
        $page = 1;
        $perPage = 100;

        do {
            $response = Http::withToken($this->apiKey)
                ->get($this->baseUrl, [
                    'page' => $page,
                    'per_page' => $perPage,
                ]);

            if ($response->failed()) {
                break;
            }

            $teams = $response->json();
            if (empty($teams)) {
                break;
            }

            foreach ($teams as $teamData) {
                $teamNameUpper = strtoupper(trim($teamData['name'] ?? ''));
                $location = strtoupper(trim($teamData['location'] ?? ''));
                $isActive = $teamData['active'] ?? true;

                // Logika Dua Lapis:
                // Lapis A: Apakah nama tim ada di whitelist resmi Valve Asia?
                $isWhitelistMatch = in_array($teamNameUpper, $valveAsiaTeamsWhitelist);

                // Lapis B: Apakah lokasi negara/region sesuai dengan whitelist spesifikmu?
                $isLocationMatch = false;
                foreach ($allowedLocations as $allowed) {
                    if ($location !== '' && str_contains($location, $allowed)) {
                        $isLocationMatch = true;
                        break;
                    }
                }

                // Jika memenuhi salah satu syarat DAN tim tersebut aktif
                if (($isWhitelistMatch || $isLocationMatch) && $isActive == true) {
                    AsiaTeam::updateOrCreate(
                        ['name' => $teamData['name']],
                        [
                            'pandascore_team_id' => $teamData['id'],
                            'slug' => $teamData['slug'] ?? Str::slug($teamData['name']),
                            'country' => $teamData['location'] ?? 'Asia',
                            'logo_url' => $teamData['image_url'],
                            'is_active' => true,
                        ]
                    );

                    $syncedCount++;
                }
            }

            $page++;
        } while (count($teams) == $perPage && $page <= 15);

        return "Berhasil menyinkronkan {$syncedCount} tim resmi Valve Asia & PandaScore!";
    }
}
