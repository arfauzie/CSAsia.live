<div class="space-y-5">
    <!-- Header Halaman -->
    <div class="bg-[#161e2b] p-5 rounded-[5px] border border-slate-800 space-y-1">
        <h1 class="text-lg font-black text-white uppercase tracking-wider">Counter Strike Professional Teams</h1>
        <p class="text-xs text-slate-400">Search and explore detailed profiles of Asia's top Counter Strike pro teams,
            from regional powerhouses to rising rosters.</p>
    </div>

    <!-- Search & Favorite Toggle Bar -->
    <div
        class="bg-[#161e2b] p-4 rounded-[5px] border border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
        <!-- Search Input -->
        <div class="w-full md:w-80 relative">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for teams..."
                class="bg-[#212c3d] text-xs text-slate-300 placeholder-slate-500 px-3.5 py-2 pl-9 rounded-[4px] border border-slate-700/50 focus:outline-none focus:border-blue-500 w-full">
            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <!-- Favorite Toggle Switch -->
        <div class="flex items-center space-x-2 text-xs text-slate-300 font-medium">
            <span>Favorite teams</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer">
                <div
                    class="w-8 h-4.5 bg-[#212c3d] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-blue-600">
                </div>
            </label>
        </div>
    </div>

    <!-- Grid Kartu Tim -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @forelse($teams as $team)
            <a href="{{ route('teams.show', $team->slug) }}"
                class="bg-[#161e2b] h-40 rounded-[5px] border border-slate-800 hover:border-slate-700 p-3.5 flex flex-col justify-between relative group cursor-pointer transition overflow-hidden shadow-md block">

                <!-- Ikon Favorit -->
                <div class="absolute top-2.5 right-2.5 text-slate-500 hover:text-amber-400 transition z-10"
                    @click.prevent="">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.690h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.690l1.519-4.674z">
                        </path>
                    </svg>
                </div>

                <!-- Logo Tim -->
                <div
                    class="flex items-center justify-center flex-1 py-1 bg-[#212c3d]/50 rounded-[4px] border border-slate-700/30 my-1 overflow-hidden px-2">
                    @if($team->logo_url)
                        <img src="{{ $team->logo_url }}" alt="{{ $team->name }}"
                            class="max-h-12 max-w-[80px] object-contain group-hover:scale-105 transition">
                    @else
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center truncate">
                            {{ $team->name }}
                        </span>
                    @endif
                </div>

                <!-- Nama Tim & Negara (Menggunakan $team->location) -->
                <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between">
                    <span
                        class="font-bold text-xs text-white truncate group-hover:text-blue-400 transition">{{ $team->name }}</span>
                    <span
                        class="text-[9px] font-semibold text-slate-400 uppercase bg-[#212c3d] px-1.5 py-0.5 rounded-[3px]">{{ $team->location ?? 'Asia' }}</span>
                </div>

            </a>
        @empty
            <div
                class="col-span-full text-center py-12 text-xs text-slate-400 bg-[#161e2b] rounded-[5px] border border-slate-800">
                Tidak ada tim Asia yang ditemukan.
            </div>
        @endforelse
    </div>
</div>