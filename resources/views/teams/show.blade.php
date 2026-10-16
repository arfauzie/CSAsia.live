@extends('layouts.app')

@section('title', $team->name . ' - Detail Tim CSAsia.live')

@section('content')
    <div class="max-w-6xl mx-auto space-y-5" x-data="{ activeTab: 'overview' }">

        <!-- BREADCRUMB -->
        <div class="text-xs text-slate-400 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>&gt;</span>
            <a href="{{ route('teams.index') }}" class="hover:text-white">Teams</a>
            <span>&gt;</span>
            <span class="text-slate-200">{{ $team->name }}</span>
        </div>

        <!-- HEADER PROFIL TIM (Wadah Level 2) -->
        <!-- HEADER TIM & METADATA -->
        <div class="space-y-4 mb-6">

            <!-- Bagian Logo & Nama Tim Utama -->
            <div class="flex items-center space-x-4">
                <!-- Logo Tim -->
                <div class="w-16 h-16 bg-[#161e2b] rounded-[5px]  p-2 flex items-center justify-center flex-shrink-0">
                    <img src="{{ $team->logo_url ?? 'https://via.placeholder.com/80?text=TEAM' }}"
                        class="max-h-full max-w-full object-contain" alt="{{ $team->name }}">
                </div>

                <!-- Nama & Alias Tim -->
                <div class="space-y-0.5">
                    <h1 class="text-xl font-black text-white tracking-wide">{{ $team->name }}</h1>
                    <p class="text-xs text-slate-400">
                        {{ $team->name }}{{ isset($team->acronym) ? ', ' . $team->acronym : '' }}
                    </p>
                </div>
            </div>

            <!-- Kotak Informasi Detail (Negara, Wilayah, Total Hadiah) -->
            <div class="bg-[#161e2b] rounded-[5px]  p-4 text-xs space-y-3">

                <!-- Negara -->
                <div class="flex justify-between items-center py-1 border-b border-slate-800/60">
                    <span class="text-slate-400">Negara</span>
                    <div class="flex items-center space-x-2">
                        <!-- Jika Anda punya helper bendera atau gambar bendera, bisa disesuaikan -->
                        <span class="font-bold text-white">{{ $team->country ?? 'Indonesia' }}</span>
                    </div>
                </div>

                <!-- Wilayah -->
                <div class="flex justify-between items-center py-1 border-b border-slate-800/60">
                    <span class="text-slate-400">Wilayah</span>
                    <span class="font-bold text-white">{{ $team->region ?? 'Asia' }}</span>
                </div>

                <!-- Total Hadiah Uang -->
                <div class="flex justify-between items-center py-1">
                    <span class="text-slate-400">Total hadiah uang</span>
                    <span class="font-mono text-slate-300">
                        {{ isset($team->total_prize_money) && $team->total_prize_money > 0 ? '$' . number_format($team->total_prize_money, 0, ',', '.') : '—' }}
                    </span>
                </div>

            </div>

        </div>

        <!-- NAVIGASI TAB (Ikhtisar, Skuad, Pertandingan, Turnamen, Statistik) -->
        <div class="bg-[#161e2b] rounded-[10px]  px-10 pt-3 mb-6">
            <div class="flex space-x-30 text-xs ">
                <button @click="activeTab = 'overview'"
                    :class="activeTab === 'overview' ? 'border-b-3 border-blue-500 text-white -mb-[1px] pb-3' : 'text-slate-400 hover:text-slate-200 -mb-[1px] pb-3'">
                    Ikhtisar
                </button>
                <button @click="activeTab = 'squad'"
                    :class="activeTab === 'squad' ? 'border-b-3 border-blue-500 text-white -mb-[1px] pb-3' : 'text-slate-400 hover:text-slate-200 -mb-[1px] pb-3'">
                    Skuad
                </button>
                <button @click="activeTab = 'matches'"
                    :class="activeTab === 'matches' ? 'border-b-3 border-blue-500 text-white -mb-[1px] pb-3' : 'text-slate-400 hover:text-slate-200 -mb-[1px] pb-3'">
                    Pertandingan
                </button>
                <button @click="activeTab = 'tournaments'"
                    :class="activeTab === 'tournaments' ? 'border-b-3 border-blue-500 text-white -mb-[1px] pb-3' : 'text-slate-400 hover:text-slate-200 -mb-[1px] pb-3'">
                    Turnamen
                </button>
                <button @click="activeTab = 'stats'"
                    :class="activeTab === 'stats' ? 'border-b-3 border-blue-500 text-white -mb-[1px] pb-3' : 'text-slate-400 hover:text-slate-200 -mb-[1px] pb-3'">
                    Statistik
                </button>
            </div>
        </div>

        <!-- TAB 1: IKHTISAR (OVERVIEW) -->
        <div x-show="activeTab === 'overview'" class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <!-- KOLOM KIRI: ROSTER & PELATIH (span 2 kolom) -->
            <div class="md:col-span-2 bg-[#161e2b] p-4 rounded-[5px]  space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">
                    ROSTER
                </h3>

                <!-- Grid Foto Pemain Inti -->
                <div class="grid grid-cols-5 gap-2.5">
                    @forelse($team->rosters->where('role', 'player')->take(5) as $player)
                        <div
                            class="bg-[#243044] rounded-[4px] border border-slate-700/60 overflow-hidden flex flex-col items-center text-center group">

                            <!-- Foto Pemain (Tanpa Bendera di Foto) -->
                            <div
                                class="w-full h-32 bg-[#161e2b] overflow-hidden relative flex items-center justify-center border-b border-slate-700/40">
                                @if(!empty($player->photo_url))
                                    <img src="{{ str_starts_with($player->photo_url, 'http') ? $player->photo_url : asset($player->photo_url) }}"
                                        alt="{{ $player->nickname }}"
                                        class="w-full h-full object-contain pt-2 group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="flex flex-col items-center justify-center text-slate-500 space-y-1">
                                        <svg class="w-8 h-8 opacity-40" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        <span class="text-[9px] font-mono">{{ $player->nickname }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Info Nickname & Bendera di Sini -->
                            <div class="p-2 w-full flex flex-col items-center space-y-1">

                                <!-- Wadah Nickname + Bendera di Sebelah Kiri -->
                                <div class="flex items-center justify-center space-x-1.5 w-full">
                                    @if(!empty($player->nationality))
                                        <img src="https://flagcdn.com/20x15/{{ strtolower($player->nationality) }}.png"
                                            alt="{{ $player->nationality }}"
                                            class="w-4 h-3 rounded-[2px] object-cover shadow-sm flex-shrink-0">
                                    @endif
                                    <span class="text-[11px] font-bold text-white truncate" title="{{ $player->nickname }}">
                                        {{ $player->nickname }}
                                    </span>
                                </div>

                                <!-- Label Status -->
                                <span
                                    class="px-1.5 py-0.5 text-[8px] font-bold bg-[#161e2b] text-emerald-400 rounded uppercase tracking-wider border border-slate-700/50">
                                    PEMAIN INTI
                                </span>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-5 text-center py-6 text-xs text-slate-500">Roster pemain belum tersedia.</div>
                    @endforelse
                </div>

                <!-- Bagian Pelatih (Coach) jika ada -->
                @php
                    $coach = $team->rosters->where('role', 'coach')->first();
                @endphp

                @if($coach)
                    <div class="bg-[#212c3d] p-2.5 rounded-[4px] border border-slate-700/40 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#161e2b] border border-slate-700 overflow-hidden flex items-center justify-center">
                                @if(!empty($coach->photo_url))
                                    <img src="{{ $coach->photo_url }}" alt="{{ $coach->nickname }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-slate-300">{{ substr($coach->nickname, 0, 2) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">{{ $coach->nickname }}</div>
                                <div class="text-[10px] text-slate-400">{{ $coach->full_name ?? 'Pelatih Tim' }}</div>
                            </div>
                        </div>
                        <span
                            class="px-2 py-1 text-[9px] font-bold bg-amber-500/10 text-amber-400 rounded uppercase border border-amber-500/20">
                            PELATIH
                        </span>
                    </div>
                @endif

                <!-- Tombol Semua Skuad -->
                <button @click="activeTab = 'squad'"
                    class="w-full py-2.5 bg-[#212c3d] hover:bg-[#283548] text-slate-300 hover:text-white text-xs font-bold rounded-[4px] border border-slate-700/60 transition uppercase tracking-wider">
                    SEMUA SKUAD
                </button>
            </div>

            <!-- KOLOM KANAN: PERTANDINGAN TERAKHIR (Recent Matches) -->
            <div class="bg-[#161e2b] p-4 rounded-[5px]  space-y-3">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">
                    PERTANDINGAN TERBARU
                </h3>

                <div class="space-y-2.5 text-xs">
                    @forelse($team->matches ?? [] as $match)
                        <!-- Card Pertandingan -->
                        <div class="bg-[#212c3d] p-3 rounded-[4px] border border-slate-700/40 space-y-2">
                            <div class="text-[10px] text-slate-400 truncate">
                                {{ $match->tournament_name ?? 'Turnamen CS2' }}
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-2 text-white font-medium">
                                        <span
                                            class="{{ $match->team_a == $team->name ? 'text-emerald-400 font-bold' : '' }}">{{ $match->team_a }}</span>
                                        <span class="text-slate-500 font-mono">{{ $match->score_a }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-white font-medium">
                                        <span
                                            class="{{ $match->team_b == $team->name ? 'text-emerald-400 font-bold' : '' }}">{{ $match->team_b }}</span>
                                        <span class="text-slate-500 font-mono">{{ $match->score_b }}</span>
                                    </div>
                                </div>
                                <!-- Status/Badge Hasil -->
                                <div>
                                    <span
                                        class="px-2 py-1 text-[10px] font-bold rounded {{ $match->winner_id == $team->id ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                                        {{ $match->winner_id == $team->id ? 'MENANG' : 'KALAH' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback jika belum ada data match -->
                        <div
                            class="bg-[#212c3d] p-3 rounded-[4px] border border-slate-700/40 text-center py-4 text-slate-400 text-xs">
                            Belum ada riwayat pertandingan terbaru.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- TAB 2: SKUAD -->
        <div x-show="activeTab === 'squad'" class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="md:col-span-3 bg-[#161e2b] p-5 rounded-[5px] border border-slate-800 space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">
                    SKUAD PEMAIN & PELATIH
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                    @forelse($team->rosters as $player)
                        <div
                            class="bg-[#243044] rounded-[4px] border border-slate-700/60 overflow-hidden flex flex-col items-center text-center group p-3 space-y-2">

                            <!-- Foto Pemain -->
                            <div
                                class="w-16 h-16 rounded-full bg-[#161e2b] border border-slate-700 overflow-hidden flex items-center justify-center">
                                @if(!empty($player->photo_url))
                                    <img src="{{ str_starts_with($player->photo_url, 'http') ? $player->photo_url : asset($player->photo_url) }}"
                                        alt="{{ $player->nickname }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-slate-300">{{ substr($player->nickname, 0, 2) }}</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-center space-x-1.5 w-full">
                                @if(!empty($player->nationality))
                                    <img src="https://flagcdn.com/20x15/{{ strtolower($player->nationality) }}.png"
                                        alt="{{ $player->nationality }}"
                                        class="w-4 h-3 rounded-[2px] object-cover shadow-sm flex-shrink-0">
                                @endif
                                <span class="text-[11px] font-bold text-white truncate" title="{{ $player->nickname }}">
                                    {{ $player->nickname }}
                                </span>
                            </div>
                            <!-- Info Nama -->
                            <div class="w-full truncate">
                                <div class="text-[10px] text-slate-400 truncate">{{ $player->full_name ?? '-' }}</div>
                            </div>

                            <!-- Badge Status Dinamis Berdasarkan Role di Database -->
                            @php
                                $roleLower = strtolower($player->role ?? 'player');

                                // Menentukan teks dan warna badge berdasarkan isi kolom role
                                if ($roleLower === 'coach') {
                                    $badgeText = 'PELATIH';
                                    $badgeClass = 'bg-amber-500/10 text-amber-400 border-amber-500/2iran';
                                } elseif ($roleLower === 'substitute' || $roleLower === 'cadangan') {
                                    $badgeText = 'DICADANGKAN';
                                    $badgeClass = 'bg-slate-700/50 text-slate-300 border-slate-600';
                                } elseif ($roleLower === 'standin') {
                                    $badgeText = 'STAND-IN';
                                    $badgeClass = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                                } else {
                                    $badgeText = 'PEMAIN INTI';
                                    $badgeClass = 'bg-[#161e2b] text-emerald-400 border-slate-700/50';
                                }
                            @endphp

                            <span
                                class="px-2 py-0.5 text-[8px] font-bold rounded uppercase tracking-wider border {{ $badgeClass }}">
                                {{ $badgeText }}
                            </span>

                        </div>
                    @empty
                        <div class="col-span-5 text-center py-6 text-xs text-slate-500">Data skuad belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- TAB 3: PERTANDINGAN (MATCHES) -->
        <div x-show="activeTab === 'matches'" class="bg-[#161e2b] p-4 rounded-[5px]  space-y-3">
            <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">HASIL &
                JADWAL PERTANDINGAN</h3>
            @php
                $teamMatches = \App\Models\MatchModel::where('team_a_name', $team->name)
                    ->orWhere('team_b_name', $team->name)
                    ->orderBy('start_time', 'desc')
                    ->get();
            @endphp

            <div class="space-y-1.5">
                @forelse($teamMatches as $m)
                    <a href="{{ route('matches.show', $m->id) }}"
                        class="bg-[#212c3d] hover:bg-[#283548] p-3 rounded-[4px] border border-slate-700/40 flex items-center justify-between transition block text-xs">
                        <span class="text-slate-400 w-32 truncate font-medium">{{ $m->round_label ?? 'Match' }}</span>

                        <div class="flex-1 grid grid-cols-2 gap-3 items-center px-4">
                            <div class="flex items-center justify-end space-x-2">
                                <span class="font-semibold text-slate-200">{{ $m->team_a_name }}</span>
                                <img src="{{ $m->team_a_logo }}" class="w-4 h-4 object-contain">
                            </div>
                            <div class="flex items-center justify-start space-x-2">
                                <img src="{{ $m->team_b_logo }}" class="w-4 h-4 object-contain">
                                <span class="font-semibold text-slate-200">{{ $m->team_b_name }}</span>
                            </div>
                        </div>

                        <div
                            class="px-3 py-1 bg-[#161e2b] rounded-[3px] font-mono font-bold text-xs text-emerald-400 border border-slate-700/50">
                            {{ $m->score_a ?? 0 }} - {{ $m->score_b ?? 0 }}
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-xs text-slate-500">Belum ada riwayat pertandingan.</div>
                @endforelse
            </div>
        </div>

        <!-- TAB 4: TURNAMEN (GAMBAR 4, 5, 6 - PRIORITY ONGOING & UPCOMING DI ATAS) -->
        <div x-show="activeTab === 'tournaments'" class="bg-[#161e2b] p-4 rounded-[5px]  space-y-4">
            <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">TURNAMEN
                YANG DIIKUTI</h3>

            @php
                // Mengambil turnamen yang diurutkan: Ongoing & Upcoming dulu, baru Finished
                $teamTournaments = \App\Models\Tournament::whereIn('status', ['ongoing', 'upcoming'])
                    ->get()
                    ->merge(\App\Models\Tournament::where('status', 'finished')->get());
            @endphp

            <div class="space-y-2">
                @forelse($teamTournaments as $tour)
                    <a href="{{ route('tournaments.show', $tour->slug) }}"
                        class="bg-[#212c3d] hover:bg-[#283548] p-3 rounded-[4px] border border-slate-700/40 flex items-center justify-between transition group block">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-7 h-7 bg-[#161e2b] rounded-[3px] p-1 flex items-center justify-center border border-slate-700/50">
                                <img src="{{ $tour->image_url ?? 'https://via.placeholder.com/30?text=CS' }}"
                                    class="max-h-full max-w-full object-contain">
                            </div>
                            <div>
                                <h4 class="font-bold text-xs text-white group-hover:text-blue-400 transition">{{ $tour->name }}
                                </h4>
                                <span class="text-[10px] text-slate-400">
                                    {{ $tour->start_date ? \Carbon\Carbon::parse($tour->start_date)->format('d M') : 'TBA' }} -
                                    {{ $tour->end_date ? \Carbon\Carbon::parse($tour->end_date)->format('d M Y') : 'TBA' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <span
                                class="text-[10px] font-bold px-2 py-0.5 rounded-[3px] uppercase {{ $tour->status === 'ongoing' ? 'bg-red-950 text-red-400 border border-red-800/60 animate-pulse' : ($tour->status === 'upcoming' ? 'bg-blue-950 text-blue-400 border border-blue-800/60' : 'bg-slate-800 text-slate-400') }}">
                                {{ $tour->status === 'ongoing' ? 'Sedang Berlangsung' : ($tour->status === 'upcoming' ? 'Mendatang' : 'Selesai') }}
                            </span>
                            <span
                                class="text-xs font-mono text-slate-300">${{ number_format($tour->prize_pool, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-xs text-slate-500">Tidak ada turnamen yang ditemukan.</div>
                @endforelse
            </div>
        </div>

        <!-- TAB 5: STATISTIK SIMPEL -->
        <div x-show="activeTab === 'stats'" class="bg-[#161e2b] p-4 rounded-[5px]  space-y-4">
            <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">STATISTIK
                UMUM TIM</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-[#212c3d] p-3.5 rounded-[4px] border border-slate-700/40 space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Turnamen</span>
                    <div class="text-lg font-bold font-mono text-white">12</div>
                    <span class="text-[10px] text-emerald-400 block">Rasio Menang: 25%</span>
                </div>

                <div class="bg-[#212c3d] p-3.5 rounded-[4px] border border-slate-700/40 space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Pertandingan</span>
                    <div class="text-lg font-bold font-mono text-white">44</div>
                    <span class="text-[10px] text-emerald-400 block">Rasio Menang: 55%</span>
                </div>

                <div class="bg-[#212c3d] p-3.5 rounded-[4px] border border-slate-700/40 space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Peta</span>
                    <div class="text-lg font-bold font-mono text-white">88</div>
                    <span class="text-[10px] text-emerald-400 block">Rasio Menang: 56%</span>
                </div>

                <div class="bg-[#212c3d] p-3.5 rounded-[4px] border border-slate-700/40 space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Ronde</span>
                    <div class="text-lg font-bold font-mono text-white">1,776</div>
                    <span class="text-[10px] text-emerald-400 block">Rasio Menang: 54%</span>
                </div>
            </div>
        </div>

    </div>
@endsection