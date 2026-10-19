<header class="bg-[#22262c] border-b border-slate-600 sticky top-0 z-50">
    <!-- GANTI BARIS INI: Mengubah 'container px-4' menjadi 'max-w-6xl px-4 md:px-0' agar sejajar dengan konten bawah -->
    <div class="max-w-6xl mx-auto px-4 md:px-0 h-16 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/csasia.png') }}" alt="CSAsia Logo" class="w-20 h-20 object-contain">
            </a>
        </div>

        <!-- Menu Utama -->
        <nav class="hidden md:flex items-center space-x-8 font-medium text-sm">
            <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-slate-400 hover:text-white' }}">Beranda</a>
            <a href="{{ route('tournaments.index') }}"
                class="{{ request()->routeIs('tournaments*') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-slate-400 hover:text-white' }}">Tournaments</a>
            <a href="{{ route('teams.index') }}"
                class="{{ request()->routeIs('teams*') ? 'text-white border-b-2 border-blue-500 pb-1' : 'text-slate-400 hover:text-white' }}">Teams</a>
        </nav>

        <!-- Search Bar -->
        <div class="flex items-center">
            <div class="relative hidden sm:block">
                <input type="text" placeholder="Search"
                    class="bg-[#1f2937] text-sm text-slate-300 placeholder-slate-500 px-4 py-1.5 pl-9 rounded-full border border-slate-500 focus:outline-none focus:border-blue-500 w-64">
                <svg class="w-4 h-4 text-slate-500 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</header>