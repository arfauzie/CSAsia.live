<div class="space-y-5">
    <!-- Header Halaman (Wadah Level 2) -->
    <div class="bg-[#22262c] p-5 rounded-[5px] space-y-1">
        <h1 class="text-lg font-black text-white uppercase tracking-wider">Counter-Strike Esports Tournaments</h1>
        <p class="text-xs text-slate-400">Platform live score khusus komunitas Asia melacak turnamen Tier S, A, B, dan
            C.</p>
    </div>

    <!-- Filter Tab & Dropdown (Wadah Level 2) -->
    <div
        class="bg-[#22262c] p-4 rounded-[5px] flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
        <!-- Tab Filter Status -->
        <div class="flex items-center space-x-2">
            <button wire:click="$set('statusFilter', 'all')"
                class="px-4 py-1.5 rounded-[4px] text-xs font-bold transition {{ $statusFilter === 'all' ? 'bg-slate-100 text-slate-950' : 'bg-[#212c3d] text-slate-300 hover:bg-[#283548] border border-slate-700/50' }}">
                All
            </button>
            <button wire:click="$set('statusFilter', 'ongoing')"
                class="px-4 py-1.5 rounded-[4px] text-xs font-bold transition {{ $statusFilter === 'ongoing' ? 'bg-slate-100 text-slate-950' : 'bg-[#212c3d] text-slate-300 hover:bg-[#283548] border border-slate-700/50' }}">
                Ongoing
            </button>
            <button wire:click="$set('statusFilter', 'upcoming')"
                class="px-4 py-1.5 rounded-[4px] text-xs font-bold transition {{ $statusFilter === 'upcoming' ? 'bg-slate-100 text-slate-950' : 'bg-[#212c3d] text-slate-300 hover:bg-[#283548] border border-slate-700/50' }}">
                Upcoming
            </button>
        </div>

    </div>

    <!-- Daftar Turnamen Dikelompokkan Berdasarkan Bulan -->
    @php
        $groupedTournaments = $tournaments->groupBy(function ($item) {
            return $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('F Y') : 'TBA';
        });
    @endphp

    @forelse($groupedTournaments as $monthYear => $items)
        <div class="space-y-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-300 px-1">{{ $monthYear }}</h2>

            <!-- Grid Kartu Horizontal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($items as $t)
                    <a href="{{ route('tournaments.show', $t->slug) }}"
                        class="bg-[#22262c] rounded-[5px] border {{ $t->status === 'ongoing' ? 'border-red-900/60 hover:border-red-600' : 'border-slate-800 hover:border-slate-700' }} overflow-hidden transition flex items-center group">

                        <!-- Thumbnail / Logo Sisi Kiri -->
                        <div
                            class="w-36 sm:w-40 h-24 bg-[#212c3d] flex-shrink-0 relative overflow-hidden flex items-center justify-center p-2.5 border-r border-slate-700/40">
                            @if(!empty($t->image_url))
                                <!-- Mengecek apakah gambar lokal atau URL eksternal -->
                                <img src="{{ Str::startsWith($t->image_url, ['http://', 'https://']) ? $t->image_url : asset($t->image_url) }}"
                                    alt="{{ $t->name }}"
                                    class="w-full h-full object-cover rounded-[3px] group-hover:scale-105 transition duration-300">
                            @else
                                <!-- Fallback jika belum diisi sama sekali -->
                                <div
                                    class="flex flex-col items-center justify-center w-full h-full bg-slate-800 text-slate-400 p-2 text-center">
                                    <span
                                        class="text-[10px] font-black uppercase text-blue-400 tracking-wider">{{ $t->tier }}-TIER</span>
                                    <span class="text-[9px] font-bold text-slate-300 truncate w-full mt-1">{{ $t->name }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi Detail Turnamen -->
                        <div class="p-3.5 flex-1 flex flex-col justify-between h-24">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                        {{ $t->tier }}-Tier • {{ $t->prize_pool ?? 'TBA' }}
                                    </span>
                                    @if($t->status === 'ongoing')
                                        <span
                                            class="text-[9px] font-bold text-red-500 uppercase tracking-widest animate-pulse">LIVE</span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-xs text-white group-hover:text-blue-400 transition line-clamp-1">
                                    {{ $t->name }}
                                </h3>
                            </div>

                            <div class="space-y-0.5 text-[10px] text-slate-400 pt-1.5 border-t border-slate-800/80">
                                <div class="flex items-center space-x-1">
                                    <span>Region Asia ({{ $t->asia_team_count }} Tim Peserta)</span>
                                </div>
                                <div class="flex items-center space-x-1 text-slate-300 font-medium">
                                    <span>{{ $t->start_date ? \Carbon\Carbon::parse($t->start_date)->format('d M') : 'TBA' }} -
                                        {{ $t->end_date ? \Carbon\Carbon::parse($t->end_date)->format('d M Y') : 'TBA' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-12 text-xs text-slate-400 bg-[#22262c] rounded-[5px]">
            Tidak ada turnamen yang ditemukan.
        </div>
    @endforelse
</div>