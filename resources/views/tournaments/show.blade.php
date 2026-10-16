@extends('layouts.app')

@section('title', $tournament->name . ' - CSAsia.live')

@section('content')
<div class="max-w-6xl mx-auto space-y-5" x-data="{ activeTab: 'overview' }">

    <!-- BREADCRUMB -->
    <div class="text-xs text-slate-400 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('tournaments.index') }}" class="hover:text-white">Tournaments</a>
        <span>&gt;</span>
        <span class="text-slate-200">{{ $tournament->name }}</span>
    </div>

    <!-- HEADER TURNAMEN (Wadah Level 2) -->
    <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-5 flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-5 shadow-xl">
        <!-- Banner / Logo Turnamen -->
        <div class="w-20 h-20 bg-[#212c3d] rounded-[4px] border border-slate-700/50 p-2 flex items-center justify-center flex-shrink-0">
            <img src="{{ $tournament->image_url ?? 'https://via.placeholder.com/80?text=CS2' }}" class="max-h-full max-w-full object-contain" alt="">
        </div>

        <!-- Info Turnamen -->
        <div class="flex-1 space-y-1.5">
            <div class="flex items-center space-x-2">
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-[3px] bg-blue-950 text-blue-400 border border-blue-800/60 uppercase">{{ $tournament->tier }}-TIER</span>
                <span class="text-[10px] text-slate-400">• {{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('M d') : 'TBA' }} - {{ $tournament->end_date ? \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') : 'TBA' }}</span>
                <span class="text-[10px] text-slate-400">• ${{ number_format($tournament->prize_pool, 0, ',', '.') }}</span>
                <span class="text-[10px] text-slate-400">• {{ $tournament->asia_team_count }} Tim Asia</span>
            </div>
            <h1 class="text-xl font-black text-white uppercase tracking-wider">{{ $tournament->name }}</h1>
            <p class="text-xs text-slate-400 line-clamp-2">Turnamen CS2 Tier {{ $tournament->tier }} resmi melacak tim-tim Asia unggulan untuk memperebutkan total hadiah ${{ number_format($tournament->prize_pool, 0, ',', '.') }}.</p>
        </div>
    </div>

    <!-- TAB NAVIGATION (Overview & Results) -->
    <div class="flex border-b border-slate-800 space-x-6 text-xs font-bold pt-1">
        <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Overview</button>
        <button @click="activeTab = 'results'" :class="activeTab === 'results' ? 'border-b-2 border-blue-500 text-white pb-2.5' : 'text-slate-400 hover:text-slate-200 pb-2.5'">Results</button>
    </div>

    <!-- TAB 1: OVERVIEW & BRACKETS -->
    <div x-show="activeTab === 'overview'" class="space-y-5">
        
        <!-- SECTION 1: NEXT MATCHES -->
        @if($tournament->status === 'ongoing' && $tournament->matches->count() > 0)
            <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-800/80 pb-2">
                    <h2 class="text-xs font-bold text-white uppercase tracking-wider">NEXT MATCHES</h2>
                    <span class="text-[10px] font-bold text-slate-400">Hari Ini</span>
                </div>

                <div class="space-y-1.5">
                    @foreach($tournament->matches as $match)
                        <div class="bg-[#212c3d] p-2.5 rounded-[4px] border border-slate-700/40 flex items-center justify-between text-xs">
                            <span class="text-[10px] text-slate-400 w-36 truncate">{{ $match->round_label ?? 'Group Stage' }}</span>
                            
                            <div class="flex-1 grid grid-cols-2 gap-2 items-center px-2">
                                <div class="flex items-center justify-end space-x-2">
                                    <span class="font-semibold text-slate-200 text-xs">{{ $match->team_a_name }}</span>
                                    <img src="{{ $match->team_a_logo }}" class="w-4 h-4 object-contain">
                                </div>
                                <div class="flex items-center justify-start space-x-2">
                                    <img src="{{ $match->team_b_logo }}" class="w-4 h-4 object-contain">
                                    <span class="font-semibold text-slate-200 text-xs">{{ $match->team_b_name }}</span>
                                </div>
                            </div>

                            @if($match->is_asia_match)
                                <a href="{{ route('matches.show', $match->id) }}" class="bg-[#161e2b] px-3 py-1 rounded-[3px] font-mono font-bold text-emerald-400 border border-slate-700/50 hover:border-emerald-500 transition">
                                    {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                </a>
                            @else
                                <span class="bg-[#161e2b] px-3 py-1 rounded-[3px] font-mono text-slate-500 border border-slate-800 opacity-60 cursor-not-allowed">
                                    {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- SECTION 2: BRACKETS ACCORDION BUKA-TUTUP -->
        <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-3">
            <div class="flex items-center justify-between border-b border-slate-800/80 pb-2">
                <h2 class="text-xs font-bold text-white uppercase tracking-wider">BRACKETS</h2>
                <span class="text-[10px] text-slate-400">Interaktif (Match Asia Aktif)</span>
            </div>

            @php
                $stages = $tournament->bracketNodes->groupBy(function($node) {
                    if (str_contains(strtolower($node->round_label), 'group')) return 'GROUP STAGE';
                    if (str_contains(strtolower($node->round_label), '3rd') || str_contains(strtolower($node->round_label), 'third')) return '3RD PLACE PLAYOFF';
                    return 'PLAYOFFS';
                });
            @endphp

            <div class="space-y-2">
                @forelse($stages as $stageName => $nodes)
                    <div x-data="{ open: true }" class="bg-[#161e2b] rounded-[5px] border border-slate-800/80 overflow-hidden">
                        
                        <button @click="open = !open" class="w-full bg-[#212c3d] hover:bg-[#283548] p-3 text-left flex justify-between items-center transition border-b border-slate-700/40">
                            <span class="font-bold text-xs text-white uppercase tracking-wider">{{ $stageName }}</span>
                            <div class="w-6 h-6 rounded-full bg-[#161e2b] flex items-center justify-center border border-slate-700/50 text-slate-300">
                                <svg x-show="!open" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                <svg x-show="open" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            </div>
                        </button>

                        <div x-show="open" class="p-3 bg-[#161e2b] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($nodes as $node)
                                <div class="bg-[#212c3d] p-3 rounded-[4px] border {{ $node->is_clickable ? 'border-slate-700/60 hover:border-blue-500 cursor-pointer' : 'border-slate-800/40 opacity-50 cursor-default' }} transition space-y-2">
                                    <div class="flex justify-between items-center text-[10px] text-slate-400 border-b border-slate-700/30 pb-1">
                                        <span class="font-bold uppercase">{{ $node->round_label }}</span>
                                        @unless($node->is_clickable)
                                            <span class="text-[9px] text-slate-500 italic">Non-Asia (Statis)</span>
                                        @endunless
                                    </div>

                                    <div class="space-y-1 text-xs font-semibold">
                                        <div class="flex justify-between items-center">
                                            <span class="{{ $node->is_clickable ? 'text-white' : 'text-slate-400' }}">{{ $node->team_a_name }}</span>
                                            <span class="font-mono text-[11px] text-slate-300">{{ $node->score_a ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="{{ $node->is_clickable ? 'text-white' : 'text-slate-400' }}">{{ $node->team_b_name }}</span>
                                            <span class="font-mono text-[11px] text-slate-300">{{ $node->score_b ?? '-' }}</span>
                                        </div>
                                    </div>

                                    @if($node->is_clickable && $node->match_id)
                                        <a href="{{ route('matches.show', $node->match_id) }}" class="block text-right text-[9px] text-blue-400 hover:underline pt-1">
                                            Lihat Match &rarr;
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-slate-500">
                        Bagan bracket belum tersedia untuk turnamen ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SECTION 3: PRIZE POOL DISTRIBUTION -->
        <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-3">
            <div class="flex items-center justify-between border-b border-slate-800/80 pb-2">
                <h2 class="text-xs font-bold text-white uppercase tracking-wider">PRIZE DISTRIBUTION</h2>
                <span class="text-[10px] font-bold text-emerald-400 font-mono">TOTAL: ${{ number_format($tournament->prize_pool, 0, ',', '.') }}</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
                @foreach($tournament->prizeDistributions as $prize)
                    <div class="bg-[#212c3d] p-2.5 rounded-[4px] border border-slate-700/40 text-center space-y-1">
                        <span class="text-[10px] font-black text-amber-400 uppercase block tracking-wider">{{ $prize->placement }}</span>
                        <span class="text-xs font-bold font-mono text-white block">{{ $prize->amount }}</span>
                        
                        @if($prize->team_name)
                            <div class="pt-1 border-t border-slate-700/40 flex items-center justify-center space-x-1.5">
                                <span class="text-[10px] font-bold text-slate-200 truncate">{{ $prize->team_name }}</span>
                            </div>
                        @else
                            <span class="text-[9px] text-slate-500 block pt-1 border-t border-slate-700/30">TBA</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SECTION 4: PARTICIPATING TEAMS / THE TEAMS -->
        <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-3">
            <div class="flex items-center justify-between border-b border-slate-800/80 pb-2">
                <h2 class="text-xs font-bold text-white uppercase tracking-wider">THE TEAMS (PESERTA)</h2>
                <span class="text-[10px] text-slate-400">Klik aktif khusus Tim Asia</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2.5">
                @foreach($tournament->standings as $team)
                    @php
                        $isAsiaTeam = \App\Models\AsiaTeam::where('name', $team->team_name)->exists();
                        $asiaTeamObj = $isAsiaTeam ? \App\Models\AsiaTeam::where('name', $team->team_name)->first() : null;
                    @endphp

                    @if($isAsiaTeam && $asiaTeamObj)
                        <a href="{{ route('teams.show', $asiaTeamObj->slug) }}" class="bg-[#212c3d] hover:bg-[#283548] p-2.5 rounded-[4px] border border-blue-900/50 hover:border-blue-500 transition flex flex-col items-center space-y-1.5 group">
                            <div class="w-8 h-8 bg-[#161e2b] rounded-[3px] p-1 flex items-center justify-center border border-slate-700/50">
                                <img src="{{ $asiaTeamObj->logo_url ?? 'https://via.placeholder.com/40' }}" class="max-h-full max-w-full object-contain">
                            </div>
                            <span class="text-[11px] font-bold text-white group-hover:text-blue-400 truncate w-full text-center">{{ $team->team_name }}</span>
                            <span class="text-[8px] bg-blue-950 text-blue-400 px-1 py-0.2 rounded font-bold uppercase">ASIA</span>
                        </a>
                    @else
                        <div class="bg-[#212c3d]/60 p-2.5 rounded-[4px] border border-slate-800 flex flex-col items-center space-y-1.5 opacity-70 cursor-default">
                            <div class="w-8 h-8 bg-[#161e2b] rounded-[3px] p-1 flex items-center justify-center border border-slate-800">
                                <img src="https://via.placeholder.com/40?text=GLOBAL" class="max-h-full max-w-full object-contain grayscale">
                            </div>
                            <span class="text-[11px] font-bold text-slate-400 truncate w-full text-center">{{ $team->team_name }}</span>
                            <span class="text-[8px] text-slate-500 uppercase">GLOBAL</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>

    <!-- TAB 2: RESULTS (PENGGANTI MATCHES ASIA - BERDASARKAN TANGGAL SEPERTI REFERENSI) -->
    <div x-show="activeTab === 'results'" class="space-y-4">
        @php
            // Mengelompokkan match berdasarkan tanggal mulai
            $groupedResults = $tournament->matches->groupBy(function($match) {
                return $match->start_time ? \Carbon\Carbon::parse($match->start_time)->format('l, M d') : 'Recent Results';
            });
        @endphp

        @forelse($groupedResults as $dateLabel => $matches)
            <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 p-4 space-y-2.5">
                <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800/80 pb-2">{{ $dateLabel }}</h3>
                
                <div class="space-y-1.5">
                    @foreach($matches as $match)
                        <a href="{{ route('matches.show', $match->id) }}" class="bg-[#212c3d] hover:bg-[#283548] p-3 rounded-[4px] border border-slate-700/40 flex items-center justify-between transition block text-xs">
                            <span class="text-slate-400 w-36 truncate font-medium">{{ $match->round_label ?? 'Match' }}</span>
                            
                            <div class="flex-1 grid grid-cols-2 gap-3 items-center px-4">
                                <div class="flex items-center justify-end space-x-2.5">
                                    <span class="font-semibold text-slate-200">{{ $match->team_a_name }}</span>
                                    <img src="{{ $match->team_a_logo }}" class="w-4 h-4 object-contain">
                                </div>
                                <div class="flex items-center justify-start space-x-2.5">
                                    <img src="{{ $match->team_b_logo }}" class="w-4 h-4 object-contain">
                                    <span class="font-semibold text-slate-200">{{ $match->team_b_name }}</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="px-3 py-1 bg-[#161e2b] rounded-[3px] font-mono font-bold text-xs text-emerald-400 border border-slate-700/50">
                                    {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                </div>
                                <span class="text-[10px] text-slate-500 bg-slate-900 px-2 py-1 rounded-[3px] border border-slate-800">0 💬</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-[#161e2b] rounded-[5px] border border-slate-800 text-center py-10 text-xs text-slate-500">
                Belum ada hasil pertandingan yang tersedia.
            </div>
        @endforelse
    </div>

</div>
@endsection