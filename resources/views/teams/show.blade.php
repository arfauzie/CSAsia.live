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
        <div
            class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-5 flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0 shadow-xl">
            <div class="flex items-center space-x-4">
                <!-- Logo Tim -->
                <div
                    class="w-16 h-16 bg-[#212c3d] rounded-[4px] border border-slate-700/50 p-2 flex items-center justify-center flex-shrink-0">
                    <img src="{{ $team->logo_url ?? 'https://via.placeholder.com/80?text=TEAM' }}"
                        class="max-h-full max-w-full object-contain" alt="">
                </div>

                <!-- Nama & Metadata -->
                <div class="space-y-1">
                    <h1 class="text-xl font-black text-white uppercase tracking-wider">{{ $team->name }}</h1>
                    <div class="flex items-center space-x-3 text-xs text-slate-400">
                        <span>Negara: <strong class="text-slate-200">{{ $team->country }}</strong></span>
                        <span>•</span>
                        <span>Wilayah: <strong class="text-slate-200">{{ $team->region ?? 'Asia' }}</strong></span>
                        <span>•</span>
                        <span>Total Hadiah: <strong
                                class="text-emerald-400 font-mono">${{ number_format($team->total_prize_money ?? 64000, 0, ',', '.') }}</strong></span>
                    </div>
                </div>
            </div>

            <span
                class="text-[10px] bg-blue-950 text-blue-400 border border-blue-800 px-2.5 py-1 rounded-[3px] font-bold uppercase tracking-wider">
                VERIFIED ASIA TEAM
            </span>
        </div>

        <!-- NAVIGASI TAB (Ikhtisar, Skuad, Pertandingan, Turnamen, Statistik) -->
        <div class="flex border-b border-slate-800 space-x-6 text-xs font-bold pt-1">
            <button @click="activeTab = 'overview'"
                :class="activeTab === 'overview' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Ikhtisar</button>
            <button @click="activeTab = 'squad'"
                :class="activeTab === 'squad' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Skuad</button>
            <button @click="activeTab = 'matches'"
                :class="activeTab === 'matches' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Pertandingan</button>
            <button @click="activeTab = 'tournaments'"
                :class="activeTab === 'tournaments' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Turnamen</button>
            <button @click="activeTab = 'stats'"
                :class="activeTab === 'stats' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Statistik</button>
        </div>

        <!-- TAB 1: IKHTISAR (OVERVIEW) -->
        <div x-show="activeTab === 'overview'" class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Roster Inti -->
            <div class="md:col-span-2 bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-3">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">ROSTER
                    SAAT INI</h3>
                <div class="grid grid-cols-5 gap-2.5">
                    @forelse($team->rosters as $player)
                        <div
                            class="bg-[#212c3d] p-2.5 rounded-[4px] border border-slate-700/40 flex flex-col items-center space-y-1.5 text-center">
                            <div
                                class="w-10 h-10 rounded-full bg-[#161e2b] border border-slate-700 overflow-hidden flex items-center justify-center">
                                <span class="text-xs font-bold text-slate-300">{{ substr($player->nickname, 0, 2) }}</span>
                            </div>
                            <span class="text-[11px] font-bold text-white truncate w-full">{{ $player->nickname }}</span>
                            <span class="text-[9px] text-slate-400 uppercase">{{ $player->role }}</span>
                        </div>
                    @empty
                        <div class="col-span-5 text-center py-6 text-xs text-slate-500">Roster belum tersedia.</div>
                    @endforelse
                </div>
            </div>

            <!-- Ringkasan Statistik Singkat -->
            <div class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-3">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">
                    RINGKASAN TAMPIL</h3>
                <div class="space-y-2 text-xs font-semibold">
                    <div class="flex justify-between items-center bg-[#212c3d] p-2.5 rounded-[4px]">
                        <span class="text-slate-400">Total Turnamen</span>
                        <span class="text-white font-mono">12</span>
                    </div>
                    <div class="flex justify-between items-center bg-[#212c3d] p-2.5 rounded-[4px]">
                        <span class="text-slate-400">Rasio Kemenangan</span>
                        <span class="text-emerald-400 font-mono">55%</span>
                    </div>
                    <div class="flex justify-between items-center bg-[#212c3d] p-2.5 rounded-[4px]">
                        <span class="text-slate-400">Peta Dimainkan</span>
                        <span class="text-white font-mono">88</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: SKUAD (ROSTER) -->
        <div x-show="activeTab === 'squad'" class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-3">
            <h3 class="text-xs font-bold text-white uppercase tracking-wider border-b border-slate-800/80 pb-2">SKUAD PEMAIN
                & PELATIH</h3>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                @forelse($team->rosters as $player)
                    <div class="bg-[#212c3d] p-3 rounded-[4px] border border-slate-700/40 text-center space-y-2">
                        <div
                            class="w-12 h-12 mx-auto rounded-full bg-[#161e2b] border border-slate-700 flex items-center justify-center font-bold text-slate-200">
                            {{ substr($player->nickname, 0, 2) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-white">{{ $player->nickname }}</h4>
                            <p class="text-[10px] text-slate-400">{{ $player->full_name }}</p>
                        </div>
                        <span
                            class="inline-block text-[9px] bg-[#161e2b] px-2 py-0.5 rounded text-blue-400 font-bold uppercase border border-slate-700/50">
                            {{ $player->role }}
                        </span>
                    </div>
                @empty
                    <div class="col-span-full text-center py-6 text-xs text-slate-500">Belum ada data anggota skuad.</div>
                @endforelse
            </div>
        </div>

        <!-- TAB 3: PERTANDINGAN (MATCHES) -->
        <div x-show="activeTab === 'matches'" class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-3">
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
        <div x-show="activeTab === 'tournaments'" class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-4">
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
        <div x-show="activeTab === 'stats'" class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-4">
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