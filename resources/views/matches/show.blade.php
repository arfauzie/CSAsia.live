@extends('layouts.app')

@section('title', $match->team_a_name . ' vs ' . $match->team_b_name . ' - Detail Match')

@section('content')
    <div class="max-w-6xl mx-auto space-y-5" x-data="{ activeTab: 'overview' }">

        <!-- Breadcrumb Navigasi -->
        <div class="text-xs text-slate-400 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>&gt;</span>
            <a href="{{ route('tournaments.show', $match->tournament->slug ?? '#') }}"
                class="hover:text-white">{{ $match->tournament->name ?? 'Turnamen' }}</a>
            <span>&gt;</span>
            <span class="text-slate-200">Detail Match</span>
        </div>

        <!-- KARTU UTAMA: MATCH OVERVIEW / SCOREBOARD (Wadah Level 2) -->
        <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-5 space-y-4 shadow-xl">
            <div class="flex justify-between items-center border-b border-slate-800/80 pb-3">
                <div>
                    <h1 class="text-xs font-bold text-white uppercase tracking-wider">MATCH OVERVIEW</h1>
                    <p class="text-[11px] text-slate-400">An overview of the match between the two teams</p>
                </div>
                <div class="flex items-center space-x-2 text-[11px] font-bold text-slate-400">
                    <span class="bg-[#212c3d] px-2.5 py-0.5 rounded-[4px] border border-slate-700/50">T</span>
                    <span class="bg-[#212c3d] px-2.5 py-0.5 rounded-[4px] border border-slate-700/50">CT</span>
                </div>
            </div>

            <!-- Header Scoreboard Tim A vs Tim B (Level 3 - Paling Cerah) -->
            <div
                class="grid grid-cols-1 md:grid-cols-7 gap-4 items-center bg-[#212c3d] p-4 rounded-[4px] border border-slate-700/40">
                <!-- Tim A -->
                <div class="md:col-span-3 flex items-center justify-between md:justify-start space-x-3">
                    <div class="text-left md:text-right flex-1">
                        <span class="text-[9px] text-slate-400 block uppercase">VRS Global rank: #9</span>
                        <span class="text-sm sm:text-base font-black text-white">{{ $match->team_a_name }}</span>
                    </div>
                    <div
                        class="w-10 h-10 bg-[#161e2b] rounded-[4px] p-1 border border-slate-700/60 flex items-center justify-center flex-shrink-0">
                        <img src="{{ $match->team_a_logo ?? 'https://via.placeholder.com/60?text=ASIA' }}"
                            class="max-h-full max-w-full object-contain" alt="">
                    </div>
                </div>

                <!-- Skor Tengah & Status (Level 2 Background) -->
                <div class="md:col-span-1 text-center bg-[#161e2b] py-2 px-3 rounded-[4px] border border-slate-700/50">
                    <div class="font-mono font-bold text-base text-white">
                        <span>{{ $match->score_a ?? 0 }}</span>
                        <span class="text-slate-500 mx-1">-</span>
                        <span>{{ $match->score_b ?? 0 }}</span>
                    </div>
                    <span
                        class="text-[9px] font-bold text-red-500 uppercase tracking-widest block {{ $match->status === 'live' ? 'animate-pulse' : '' }}">
                        {{ $match->status }}
                    </span>
                </div>

                <!-- Tim B -->
                <div class="md:col-span-3 flex items-center justify-start space-x-3">
                    <div
                        class="w-10 h-10 bg-[#161e2b] rounded-[4px] p-1 border border-slate-700/60 flex items-center justify-center flex-shrink-0">
                        <img src="{{ $match->team_b_logo ?? 'https://via.placeholder.com/60?text=TEAM' }}"
                            class="max-h-full max-w-full object-contain" alt="">
                    </div>
                    <div class="flex-1">
                        <span class="text-[9px] text-slate-400 block uppercase">VRS Global rank: #18</span>
                        <span class="text-sm sm:text-base font-black text-white">{{ $match->team_b_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Map (Level 3 - Paling Cerah) -->
            <div class="space-y-1.5">
                <!-- Map 1 -->
                <div
                    class="bg-[#212c3d] p-3 rounded-[4px] border border-slate-700/40 flex items-center justify-between text-xs font-semibold">
                    <div class="flex items-center space-x-2.5 w-32">
                        <span
                            class="w-5 h-5 rounded-full bg-emerald-600/30 text-emerald-400 flex items-center justify-center text-[10px] font-bold">13</span>
                        <span class="text-[11px] text-slate-400">7 : 6</span>
                        <span
                            class="text-[9px] bg-blue-900/60 text-blue-300 px-1.5 py-0.5 rounded-[3px] font-bold">PICK</span>
                    </div>
                    <div class="text-center flex-1 font-black tracking-wider text-white">
                        CACHE <span class="text-[9px] text-red-500 font-bold block animate-pulse">LIVE</span>
                    </div>
                    <div class="flex items-center justify-end space-x-2.5 w-32 text-right">
                        <span class="text-[11px] text-slate-400">4 : 5</span>
                        <span
                            class="w-5 h-5 rounded-full bg-[#161e2b] text-slate-300 flex items-center justify-center text-[10px] font-bold">9</span>
                    </div>
                </div>

                <!-- Map 2 -->
                <div
                    class="bg-[#212c3d]/60 p-3 rounded-[4px] border border-slate-700/30 flex items-center justify-between text-xs font-semibold text-slate-400">
                    <div class="w-32">-</div>
                    <div class="text-center flex-1 font-bold tracking-wider text-slate-300">DUST 2</div>
                    <div class="w-32 text-right">
                        <span
                            class="text-[9px] bg-blue-900/40 text-blue-400 px-1.5 py-0.5 rounded-[3px] font-bold mr-2">PICK</span>
                        <span>-</span>
                    </div>
                </div>

                <!-- Map 3 -->
                <div
                    class="bg-[#212c3d]/60 p-3 rounded-[4px] border border-slate-700/30 flex items-center justify-between text-xs font-semibold text-slate-400">
                    <div class="w-32">-</div>
                    <div class="text-center flex-1 font-bold tracking-wider text-slate-300">NUKE</div>
                    <div class="w-32 text-right">-</div>
                </div>
            </div>
        </div>

        <!-- TAB NAVIGATION (Overview / Matchup) -->
        <div class="flex border-b border-slate-800 space-x-6 text-xs font-bold pt-1">
            <button @click="activeTab = 'overview'"
                :class="activeTab === 'overview' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">
                Overview
            </button>
            <button @click="activeTab = 'matchup'"
                :class="activeTab === 'matchup' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">
                Matchup
            </button>
        </div>

        <!-- KONTEN TAB 1: OVERVIEW (Roster Pemain - Wadah Level 2 & Item Level 3) -->
        <div x-show="activeTab === 'overview'" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Roster Tim A -->
            <div class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-800/80 pb-2.5">
                    <h3 class="font-bold text-xs text-white uppercase">{{ $match->team_a_name }}</h3>
                    <span class="text-[9px] text-slate-400">The current roster</span>
                </div>
                <div class="grid grid-cols-5 gap-2 text-center">
                    @php
                        $teamAObj = \App\Models\AsiaTeam::with('rosters')->where('name', $match->team_a_name)->first();
                    @endphp
                    @if($teamAObj && $teamAObj->rosters->count() > 0)
                        @foreach($teamAObj->rosters as $player)
                            <div
                                class="flex flex-col items-center space-y-1 bg-[#212c3d] p-2 rounded-[4px] border border-slate-700/40">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#161e2b] border border-slate-700 overflow-hidden flex items-center justify-center">
                                    <span class="text-[10px] font-bold text-slate-300">{{ substr($player->nickname, 0, 2) }}</span>
                                </div>
                                <span
                                    class="text-[10px] font-semibold text-slate-200 truncate w-full">{{ $player->nickname }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-5 text-xs text-slate-500 py-4">Roster belum tersedia.</div>
                    @endif
                </div>
            </div>

            <!-- Roster Tim B -->
            <div class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-800/80 pb-2.5">
                    <h3 class="font-bold text-xs text-white uppercase">{{ $match->team_b_name }}</h3>
                    <span class="text-[9px] text-slate-400">The current roster</span>
                </div>
                <div class="grid grid-cols-5 gap-2 text-center">
                    @php
                        $teamBObj = \App\Models\AsiaTeam::with('rosters')->where('name', $match->team_b_name)->first();
                    @endphp
                    @if($teamBObj && $teamBObj->rosters->count() > 0)
                        @foreach($teamBObj->rosters as $player)
                            <div
                                class="flex flex-col items-center space-y-1 bg-[#212c3d] p-2 rounded-[4px] border border-slate-700/40">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#161e2b] border border-slate-700 overflow-hidden flex items-center justify-center">
                                    <span class="text-[10px] font-bold text-slate-300">{{ substr($player->nickname, 0, 2) }}</span>
                                </div>
                                <span
                                    class="text-[10px] font-semibold text-slate-200 truncate w-full">{{ $player->nickname }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-5 text-xs text-slate-500 py-4">Roster belum tersedia.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- KONTEN TAB 2: MATCHUP (Map Breakdown & Head to Head - Wadah Level 2 & Item Level 3) -->
        <div x-show="activeTab === 'matchup'" class="space-y-5">

            <!-- MAP BREAKDOWN -->
            <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-3">
                <div class="flex justify-between items-center border-b border-slate-800/80 pb-2.5">
                    <div>
                        <h3 class="font-bold text-xs text-white uppercase tracking-wider">MAP BREAKDOWN</h3>
                        <p class="text-[10px] text-slate-400">How each team performed on each map</p>
                    </div>
                    <div class="flex items-center space-x-2 text-[11px] font-semibold">
                        <span class="text-slate-300">{{ $match->team_a_name }}</span>
                        <span class="text-slate-500">vs</span>
                        <span class="text-slate-300">{{ $match->team_b_name }}</span>
                    </div>
                </div>

                <!-- Tabel Statistik Map -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead
                            class="bg-[#212c3d] text-slate-400 uppercase font-bold border-b border-slate-800 text-[10px]">
                            <tr>
                                <th class="p-2.5">Played</th>
                                <th class="p-2.5">W/L</th>
                                <th class="p-2.5">Win%</th>
                                <th class="p-2.5 text-center">Map</th>
                                <th class="p-2.5 text-right">Win%</th>
                                <th class="p-2.5 text-right">W/L</th>
                                <th class="p-2.5 text-right">Played</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 font-mono text-[11px]">
                            <tr class="hover:bg-[#212c3d]/50 transition">
                                <td class="p-2.5 text-slate-300">1</td>
                                <td class="p-2.5 text-slate-400">0 / 1</td>
                                <td class="p-2.5 text-red-400">0.0%</td>
                                <td class="p-2.5 text-center font-sans font-bold text-white">Ancient</td>
                                <td class="p-2.5 text-right text-emerald-400">33.3%</td>
                                <td class="p-2.5 text-right text-slate-400">1 / 2</td>
                                <td class="p-2.5 text-right text-slate-300">3</td>
                            </tr>
                            <tr class="hover:bg-[#212c3d]/50 transition">
                                <td class="p-2.5 text-slate-300">11</td>
                                <td class="p-2.5 text-slate-400">7 / 4</td>
                                <td class="p-2.5 text-emerald-400">63.6%</td>
                                <td class="p-2.5 text-center font-sans font-bold text-white">Anubis</td>
                                <td class="p-2.5 text-right text-emerald-400">100.0%</td>
                                <td class="p-2.5 text-right text-slate-400">1 / 0</td>
                                <td class="p-2.5 text-right text-slate-300">1</td>
                            </tr>
                            <tr class="hover:bg-[#212c3d]/50 transition">
                                <td class="p-2.5 text-slate-300">8</td>
                                <td class="p-2.5 text-slate-400">3 / 5</td>
                                <td class="p-2.5 text-amber-400">37.5%</td>
                                <td class="p-2.5 text-center font-sans font-bold text-white">Cache</td>
                                <td class="p-2.5 text-right text-red-400">0.0%</td>
                                <td class="p-2.5 text-right text-slate-400">0 / 3</td>
                                <td class="p-2.5 text-right text-slate-300">3</td>
                            </tr>
                            <tr class="hover:bg-[#212c3d]/50 transition">
                                <td class="p-2.5 text-slate-300">9</td>
                                <td class="p-2.5 text-slate-400">3 / 6</td>
                                <td class="p-2.5 text-amber-400">33.3%</td>
                                <td class="p-2.5 text-center font-sans font-bold text-white">Dust 2</td>
                                <td class="p-2.5 text-right text-red-400">0.0%</td>
                                <td class="p-2.5 text-right text-slate-400">0 / 2</td>
                                <td class="p-2.5 text-right text-slate-300">2</td>
                            </tr>
                            <tr class="hover:bg-[#212c3d]/50 transition">
                                <td class="p-2.5 text-slate-300">14</td>
                                <td class="p-2.5 text-slate-400">8 / 6</td>
                                <td class="p-2.5 text-emerald-400">57.1%</td>
                                <td class="p-2.5 text-center font-sans font-bold text-white">Mirage</td>
                                <td class="p-2.5 text-right text-red-400">0.0%</td>
                                <td class="p-2.5 text-right text-slate-400">0 / 2</td>
                                <td class="p-2.5 text-right text-slate-300">2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- HEAD TO HEAD RESULTS -->
            <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-3">
                <div class="flex justify-between items-center border-b border-slate-800/80 pb-2.5">
                    <h3 class="font-bold text-xs text-white uppercase tracking-wider">HEAD TO HEAD RESULTS</h3>
                    <span
                        class="text-[11px] bg-[#212c3d] px-2.5 py-0.5 rounded-[4px] font-mono font-bold text-slate-300 border border-slate-700/50">2
                        : 0</span>
                </div>

                <div class="space-y-2 text-xs">
                    <div
                        class="bg-[#212c3d] p-3 rounded-[4px] border border-slate-700/40 flex justify-between items-center">
                        <span class="text-slate-300">IEM Cologne 2025</span>
                        <div class="flex items-center space-x-2.5 font-semibold text-white">
                            <span>{{ $match->team_a_name }}</span>
                            <span
                                class="bg-emerald-600/30 text-emerald-400 px-2 py-0.5 rounded-[3px] font-mono text-[11px]">2
                                : 0</span>
                            <span>{{ $match->team_b_name }}</span>
                        </div>
                    </div>
                    <div
                        class="bg-[#212c3d] p-3 rounded-[4px] border border-slate-700/40 flex justify-between items-center">
                        <span class="text-slate-300">PGL Astana 2025</span>
                        <div class="flex items-center space-x-2.5 font-semibold text-white">
                            <span>{{ $match->team_a_name }}</span>
                            <span
                                class="bg-emerald-600/30 text-emerald-400 px-2 py-0.5 rounded-[3px] font-mono text-[11px]">2
                                : 1</span>
                            <span>{{ $match->team_b_name }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection