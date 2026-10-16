<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\AsiaTeam;
use Illuminate\Support\Facades\Log;

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
        // Whitelist ID PandaScore Resmi untuk Tim Inti/Utama Asia
        // (Silakan terus tambahkan baris ID baru di sini setelah Anda mencarinya di browser)
        $valveAsiaTeamsIds = [
            3248   => 'TYLOO',
            127114 => 'Rooster',
            138151 => 'NEXVOID',
            135177 => 'BC.Game',
            3272 => 'The Mongolz',
            134264 => 'Chinggis Warriors',
            134746 => 'FlyQuest',
            138284 => '5star',
            126439 => 'Lynn Vision',
            135915 => 'DEPO',
            125873 => 'Ground Zero',
            137594 => 'THUNDER dOWNUNDER',
            133900 => 'The Huns Esports',
            138092 => 'Abyssal',
            135214 => 'Alter Ego',
            130329 => 'Rare Atom',
            137155 => 'Kaleido',
            136330 => 'Just Swing',
            133497 => 'KZG',
            138702 => 'Vitalem Aerem',
            131110 => 'Mindfreak',
            138110 => 'THE UNIT',
            135436 => 'Revenge',
            127125 => 'MARKandLARRY',
            138283 => 'Haunted House',
            137121 => 'TEAM EDM',
            139356 => 'BGNS Orange',
            126269 => 'madlikewizards',
            137344 => 'Legion',
            135428 => 'SemperFi Esports',
            135162 => 'Boring Players',
            139287 => 'Fruju',
            126278 => 'FURY',
            138015 => 'Ding Cuts',
            136767 => 'Banzai',
            139357 => '1337',
            139281 => 'bLight blue',
            139128 => 'QuantumX'
        ];

        $syncedCount = 0;

        foreach ($valveAsiaTeamsIds as $pandascoreId => $teamName) {

            // Tembak API secara spesifik langsung menggunakan ID unik tim ke PandaScore
            $response = Http::withToken($this->apiKey)
                ->get("https://api.pandascore.co/teams/{$pandascoreId}");

            // Jika gagal terhubung atau ID tidak ditemukan di API, catat log dan lewati ke tim berikutnya
            if ($response->failed()) {
                Log::error("Gagal menarik data dari PandaScore untuk ID Tim: {$pandascoreId} ({$teamName})");
                continue;
            }

            $teamData = $response->json();

            if (!empty($teamData)) {
                // Simpan atau perbarui data ke database internal Anda
                // Menggunakan pandascore_team_id sebagai kunci utama agar data 100% unik
                AsiaTeam::updateOrCreate(
                    ['pandascore_team_id' => $teamData['id']],
                    [
                        'name' => $teamData['name'], // Mengambil nama murni dari API PandaScore
                        'slug' => $teamData['slug'] ?? Str::slug($teamData['name']),
                        'country' => $teamData['location'] ?? 'Asia',
                        'logo_url' => $teamData['image_url'] ?? 'https://placehold.co', // Fallback jika logo kosong
                        'is_active' => true,
                    ]
                );

                $syncedCount++;
            }

            // Jeda 0.2 detik (200.000 mikrodetik) per tim agar aman dari limit pemblokiran API PandaScore
            usleep(200000);
        }

        return "Berhasil menyinkronkan {$syncedCount} tim inti teratas Asia langsung berdasarkan ID resmi!";
    }
}
