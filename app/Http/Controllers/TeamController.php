<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsiaTeam;

class TeamController extends Controller
{
    public function index()
    {
        // Ambil semua tim Asia dari database, urutkan berdasarkan nama
        $teams = AsiaTeam::orderBy('name', 'asc')->get();

        // Tampilkan ke view (kita akan buat view-nya sebentar lagi)
        return view('teams.index', compact('teams'));
    }
}
