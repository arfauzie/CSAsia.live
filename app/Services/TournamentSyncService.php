<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Tournament;
use App\Models\AsiaTeam;
use Carbon\Carbon;

class TournamentSyncService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.pandascore.co/csgo';

    public function __construct()
    {
        $this->apiKey = env('PANDASCORE_API_KEY');
    }

    public function syncTournamentsForAlterEgo()
    {
        $alterEgoId = 135214; // ID PandaScore Alter Ego

        try {
            $response = Http::withToken($this->apiKey)
                ->get("{$this->baseUrl}/teams/{$alterEgoId}/tournaments", [
                    'sort' => '-begin_at',
                    'per_page' => 10,
                ]);

            if ($response->failed()) {
                Log::error("Gagal mengambil turnamen untuk Alter Ego");
                return false;
            }

            $tournaments = $response->json();

            foreach ($tournaments as $tData) {
                // Upsert Turnamen ke database lokal
                $tournament = Tournament::updateOrCreate(
                    ['id' => $tData['id']],
                    [
                        'name' => $tData['name'],
                        'slug' => Str::slug($tData['name'] . '-' . $tData['id']),
                        'tier' => strtoupper($tData['tier'] ?? 'C'),
                        'status' => $this->resolveStatus($tData['begin_at'], $tData['end_at']),
                        'start_date' => $tData['begin_at'] ? Carbon::parse($tData['begin_at'])->toDateTimeString() : null,
                        'end_date' => $tData['end_date'] ? Carbon::parse($tData['end_date'])->toDateTimeString() : null,
                        'image_url' => $tData['league']['image_url'] ?? null,
                        'prizepool' => $tData['prizepool'] ?? null,
                    ]
                );

                // Hubungkan turnamen dengan Alter Ego melalui tabel pivot (jika relasi many-to-many ada)
                // Pastikan model Tournament memiliki relasi 'teams'
                $tournament->teams()->syncWithoutDetaching([$alterEgoId]);
            }

            return "Berhasil sync turnamen Alter Ego!";
        } catch (\Exception $e) {
            Log::error("Error sync turnamen AE: " . $e->getMessage());
            return false;
        }
    }

    private function resolveStatus($beginAt, $endAt)
    {
        if (!$beginAt) return 'upcoming';
        $now = Carbon::now();
        $start = Carbon::parse($beginAt);
        $end = $endAt ? Carbon::parse($endAt) : null;

        if ($now->lt($start)) return 'upcoming';
        if ($end && $now->gt($end)) return 'finished';
        return 'ongoing';
    }
}
