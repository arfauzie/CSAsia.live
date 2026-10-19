<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsiaTeam;
use App\Models\RosterMember;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // <-- INI YANG KURANG (PENTING)

class TeamController extends Controller
{
    public function index()
    {
        $teams = AsiaTeam::orderBy('name', 'asc')->get();
        return view('teams.index', compact('teams'));
    }

    public function show($slug)
    {

        // 1. Cari data tim dasar dari database lokal
        $teamModel = AsiaTeam::where('slug', $slug)->firstOrFail();

        // 2. Ambil API Key PandaScore dari environment
        $apiKey = env('PANDASCORE_API_KEY');

        // 3. Tembak API PandaScore untuk mendapatkan roster terbaru
        $response = Http::withToken($apiKey)
            ->get("https://api.pandascore.co/teams/{$teamModel->pandascore_team_id}");

        if ($response->successful()) {
            $apiData = $response->json();
            $apiPlayers = $apiData['players'] ?? [];

            // DAFTAR PEMAIN YANG INGIN DIABAIKAN (Sudah keluar dari tim)
            $ignoredNicknames = ['b1lal', 'BOROS']; // Masukkan nickname di sini

            // Filter pemain dari API, buang yang masuk daftar ignored
            $apiPlayers = array_filter($apiPlayers, function ($player) use ($ignoredNicknames) {
                return !in_array($player['name'] ?? '', $ignoredNicknames);
            });

            foreach ($apiPlayers as $player) {
                $nickname = $player['name'] ?? '-';
                $apiImageUrl = $player['image_url'] ?? null;
                $apiNationality = $player['nationality'] ?? null; // <-- Ambil data nationality dari API

                $existingPlayer = RosterMember::where('asia_team_id', $teamModel->id)
                    ->where('nickname', $nickname)
                    ->first();

                if ($existingPlayer) {
                    // Pertahankan foto manual jika sudah diset
                    $finalPhotoUrl = $existingPlayer->photo_url;
                    if (empty($finalPhotoUrl) || !str_contains($finalPhotoUrl, '/images/')) {
                        $finalPhotoUrl = $apiImageUrl;
                    }

                    // Pertahankan nationality manual jika sudah ada, atau pakai dari API
                    $finalNationality = $existingPlayer->nationality ?: $apiNationality;

                    $existingPlayer->update([
                        'full_name' => trim(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')),
                        'role' => $player['role'] ?? 'player',
                        'nationality' => $finalNationality,
                        'photo_url' => $finalPhotoUrl,
                    ]);
                } else {
                    RosterMember::create([
                        'asia_team_id' => $teamModel->id,
                        'nickname' => $nickname,
                        'full_name' => trim(($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')),
                        'role' => $player['role'] ?? 'player',
                        'nationality' => $apiNationality, // <-- Masukkan dari API
                        'photo_url' => $apiImageUrl,
                    ]);
                }
            }

            // HAPUS PEMAIN YANG SUDAH KELUAR (Contoh: dwi/bborne yang tidak ada lagi di API)
            RosterMember::whereIn('nickname', $ignoredNicknames)->delete();
        } else {
            Log::warning("Gagal mengambil detail roster dari API untuk tim ID: {$teamModel->pandascore_team_id}");
        }

        // 4. Ambil data roster bersih dari database lokal
        $rosters = RosterMember::where('asia_team_id', $teamModel->id)->get();

        // 5. Susun data untuk dikirim ke View
        $team = (object) [
            'name' => $teamModel->name,
            'slug' => $teamModel->slug,
            'country' => $teamModel->country,
            'region' => $teamModel->region ?? 'Asia',
            'logo_url' => $teamModel->logo_url,
            'total_prize_money' => $teamModel->total_prize_money ?? 0,
            'rosters' => $rosters
        ];

        return view('teams.show', compact('team'));
    }
}
