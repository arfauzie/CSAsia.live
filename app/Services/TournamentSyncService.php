<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AsiaTeam;
use App\Models\Tournament;

class TournamentSyncService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('PANDASCORE_API_KEY', config('services.pandascore.token'));
    }

    public function syncTournaments()
    {
        // 1. Ambil semua tim Asia yang aktif dari database lokal
        $asiaTeams = AsiaTeam::where('is_active', true)->get();

        if ($asiaTeams->isEmpty()) {
            Log::warning('Sync Turnamen dilewati: Tidak ada tim Asia aktif di tabel asia_teams.');
            return;
        }

        $validTiers = ['S', 'A', 'B', 'C', 'D']; // Masukkan tier sesuai kebutuhan (termasuk D/uncategorized jika ada)

        // 2. Loop setiap tim Asia untuk menarik turnamen yang mereka ikuti secara spesifik
        foreach ($asiaTeams as $team) {
            $response = Http::get("https://api.pandascore.co/csgo/teams/{$team->pandascore_team_id}/tournaments", [
                'token' => $this->apiKey,
                'filter[status]' => 'running,upcoming',
                'per_page' => 50
            ]);

            if (!$response->successful()) {
                continue; // Lewati jika tim ini gagal di-fetch
            }

            $tournaments = $response->json();

            if (!is_array($tournaments)) {
                continue;
            }

            // 3. Proses setiap turnamen yang diikuti oleh tim Asia ini
            foreach ($tournaments as $tournament) {
                $tier = strtoupper($tournament['tier'] ?? 'C');

                // Validasi tier (S, A, B, C, D)
                if (in_array($tier, $validTiers)) {
                    $status = $this->resolveStatus($tournament['begin_at'] ?? null, $tournament['end_at'] ?? null);

                    // Ambil daftar tim yang ikut di turnamen ini dari API (jika ada)
                    $tournamentTeamIds = collect($tournament['teams'] ?? [])->pluck('id')->map(fn($id) => (int)$id)->toArray();
                    $asiaTeamIds = $asiaTeams->pluck('pandascore_team_id')->map(fn($id) => (int)$id)->toArray();

                    // Hitung berapa banyak tim Asia dari 34+ tim kita yang ikut di turnamen ini
                    $intersect = array_intersect($tournamentTeamIds, $asiaTeamIds);
                    $asiaTeamCount = max(1, count($intersect)); // Minimal 1 karena tim ini sedang dicek

                    $imageUrl = $tournament['videogame_version'] ?? ($tournament['league']['image_url'] ?? null);

                    // 4. Simpan/Update ke database lokal agar langsung muncul di web
                    Tournament::updateOrCreate(
                        ['pandascore_tournament_id' => (string) $tournament['id']],
                        [
                            'name' => $tournament['name'],
                            'slug' => Str::slug($tournament['name']),
                            'tier' => $tier,
                            'status' => $status,
                            'start_date' => $tournament['begin_at'] ?? null,
                            'end_date' => $tournament['end_at'] ?? null,
                            'asia_team_count' => $asiaTeamCount,
                            'prize_pool' => $tournament['prizepool'] ?? null,
                            'image_url' => $imageUrl,
                        ]
                    );
                }
            }
        }
    }

    // Alias agar method pemanggil manapun tidak error
    public function syncTournamentsForAsiaTeams()
    {
        return $this->syncTournaments();
    }

    private function resolveStatus($beginAt, $endAt)
    {
        if (!$beginAt) return 'upcoming';

        $now = Carbon::now();
        $start = Carbon::parse($beginAt);
        $end = $endAt ? Carbon::parse($endAt) : null;

        if ($now->lt($start)) {
            return 'upcoming';
        }
        if ($end && $now->gt($end)) {
            return 'finished';
        }
        return 'ongoing';
    }
}
