
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    
    <!-- KOLOM KIRI: Match List (LIVE & Hari Ini) -->
    <div class="space-y-3">
        <!-- Header Section (Wadah Level 2) -->
        <div class="bg-[#22262c] p-3 rounded-[5px]  flex items-center space-x-2.5">
            <span class="flex h-2.5 w-2.5 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
            </span>
            <h2 class="font-bold text-xs uppercase tracking-wider text-red-500">Today</h2>
        </div>

        <!-- WADAH TUNGGAL UNTUK SEMUA MATCH (Container Level 2) -->
        <div class="bg-[#22262c] rounded-[5px]  p-2.5 space-y-4">
            @forelse($tournaments as $t)
                @if($t->matches->count() > 0)
                    <!-- GROUP TURNAMEN DALAM SATU WADAH -->
                    <div class="space-y-1.5">
                        <!-- Baris Pemisah Turnamen (Group Header) -->
                        <div class="px-1 py-1 flex items-center  pb-1.5 mb-1.5">
                            <a href="{{ route('tournaments.show', $t->slug) }}" class="flex items-center space-x-2 group">
                                <div class="w-5 h-5 bg-[#313840] rounded-[3px] p-0.5 border border-slate-700/60 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ $t->image_url ?? 'https://via.placeholder.com/30?text=CS' }}" alt="" class="max-h-full max-w-full object-contain">
                                </div>
                                <span class="font-bold text-xs text-slate-200 group-hover:text-blue-400 transition">{{ $t->name }}</span>
                            </a>
                        </div>

                        <!-- LIST MATCH DARI TURNAMEN INI (Level 3) -->
                        @foreach($t->matches as $match)
                            <a href="{{ route('matches.show', $match->id) }}" class="bg-[#313840] hover:bg-[#283548] p-2.5 rounded-[4px] border border-slate-700/40 flex items-center justify-between transition group block">
                                
                                <!-- Jam / Status -->
                                <div class="w-20 text-[11px] text-slate-400 flex flex-col justify-center">
                                    @if($match->status === 'live')
                                        <span class="text-red-400 font-bold uppercase text-[10px] animate-pulse">LIVE</span>
                                        <span class="text-[9px] text-slate-400">{{ $match->current_map ?? 'Map 3' }}</span>
                                    @else
                                        <span class="font-semibold text-slate-200">{{ $match->start_time ? \Carbon\Carbon::parse($match->start_time)->format('H:i') : '07:20' }}</span>
                                        <span class="text-[9px] uppercase text-slate-400">{{ $match->status }}</span>
                                    @endif
                                </div>

                                <!-- Tim A vs Tim B & Logo -->
                                <div class="flex-1 grid grid-cols-2 gap-2 items-center px-1">
                                    <!-- Tim A -->
                                    <div class="flex items-center justify-end space-x-2">
                                        <span class="font-semibold text-xs text-slate-100 group-hover:text-white truncate">{{ $match->team_a_name }}</span>
                                        <div class="w-5 h-5 bg-[#22262c] rounded-[3px] p-0.5 flex items-center justify-center flex-shrink-0">
                                            <img src="{{ $match->team_a_logo ?? 'https://via.placeholder.com/20' }}" alt="" class="max-h-full max-w-full object-contain">
                                        </div>
                                    </div>

                                    <!-- Tim B -->
                                    <div class="flex items-center justify-start space-x-2">
                                        <div class="w-5 h-5 bg-[#22262c] rounded-[3px] p-0.5 flex items-center justify-center flex-shrink-0">
                                            <img src="{{ $match->team_b_logo ?? 'https://via.placeholder.com/20' }}" alt="" class="max-h-full max-w-full object-contain">
                                        </div>
                                        <span class="font-semibold text-xs text-slate-100 group-hover:text-white truncate">{{ $match->team_b_name }}</span>
                                    </div>
                                </div>

                                <!-- Skor Tengah -->
                                <div class="px-2.5 py-1 font-mono font-bold text-xs bg-[#22262c] text-slate-200 rounded-[3px] border border-slate-700/50 min-w-[45px] text-center">
                                    <span class="{{ $match->score_a > $match->score_b ? 'text-emerald-400' : 'text-slate-300' }}">{{ $match->score_a ?? 0 }}</span>
                                    <span class="text-slate-500 mx-0.5">-</span>
                                    <span class="{{ $match->score_b > $match->score_a ? 'text-emerald-400' : 'text-slate-300' }}">{{ $match->score_b ?? 0 }}</span>
                                </div>

                            </a>
                        @endforeach
                    </div>
                @endif
            @empty
                <div class="text-center py-10 text-xs text-slate-400">
                    Belum ada match Asia terjadwal hari ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- KOLOM KANAN: Turnamen Teratas -->
    <div class="space-y-3">
        <!-- Header Section (Wadah Level 2) -->
        <div class="bg-[#22262c] p-3 rounded-[5px] ">
            <h2 class="font-bold text-xs uppercase tracking-wider text-slate-200">TURNAMEN TERATAS</h2>
        </div>

        <!-- WADAH UTAMA LIST TURNAMEN (Level 2) -->
        <div class="bg-[#22262c] rounded-[5px]  p-2.5 space-y-2">
            @foreach($tournaments as $t)
                <!-- ITEM TURNAMEN (Level 3) -->
                <a href="{{ route('tournaments.show', $t->slug) }}" class="block bg-[#313840] hover:bg-[#283548] p-3 rounded-[4px] border border-slate-700/40 transition group">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center space-x-2">
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-[3px] bg-blue-950 text-blue-400 border border-blue-800/60 uppercase">{{ $t->tier }}-TIER</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium capitalize">{{ $t->status === 'ongoing' ? 'Sedang berlangsung' : $t->status }}</span>
                    </div>

                    <!-- Logo & Nama Turnamen -->
                    <div class="flex items-center space-x-2.5">
                        <div class="w-6 h-6 bg-[#22262c] rounded-[3px] p-0.5 border border-slate-700/60 flex items-center justify-center flex-shrink-0">
                            <img src="{{ $t->image_url ?? 'https://via.placeholder.com/30?text=CS' }}" alt="" class="max-h-full max-w-full object-contain">
                        </div>
                        <h3 class="font-bold text-xs text-slate-100 group-hover:text-blue-400 transition">{{ $t->name }}</h3>
                    </div>

                    <div class="text-[10px] text-slate-400 pl-8 mt-1">
                        {{ $t->asia_team_count }} Tim Asia Peserta
                    </div>
                </a>
            @endforeach
        </div>

        <div>
            <a href="{{ route('tournaments.index') }}" class="block w-full text-center py-2 bg-[#22262c] hover:bg-[#313840]  text-[11px] font-bold rounded-[5px] uppercase tracking-wider text-blue-400 transition">
                Semua Turnamen
            </a>
        </div>
    </div>

</div>