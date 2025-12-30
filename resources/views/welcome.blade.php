<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tickify - Konser Seru!</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-black text-white antialiased">

    <nav class="fixed w-full z-50 top-0 start-0 border-b border-white/10 bg-black/30 backdrop-blur-md transition-all duration-300">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4">
            
            <a href="/" class="flex items-center">
                <img src="{{ asset('logo.png') }}" class="h-10 w-auto" alt="Tickify">
                <span class="ml-3 text-xl font-bold tracking-wide text-white hidden md:block">TICKIFY</span>
            </a>

            <div class="hidden md:flex flex-1 mx-10 max-w-lg">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" class="block w-full p-2.5 ps-10 text-sm text-white border border-gray-600 rounded-full bg-white/10 focus:ring-purple-500 focus:border-purple-500 placeholder-gray-300 transition" placeholder="Cari artis atau venue...">
                </div>
            </div>

            <div class="flex space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white hover:text-purple-400 font-bold text-sm px-4 py-2 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-gray-300 font-medium text-sm px-4 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="text-white bg-purple-600 hover:bg-purple-700 font-bold rounded-full text-sm px-5 py-2 shadow-lg shadow-purple-900/50 transition transform hover:scale-105">Daftar</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="relative w-full h-[600px] overflow-hidden bg-black" 
        x-data="{ 
            activeSlide: 0, 
            slides: {{ $concerts->take(5)->count() }}, 
            loop() { setInterval(() => { this.next() }, 5000) },
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
            prev() { this.activeSlide = (this.activeSlide === 0) ? this.slides - 1 : this.activeSlide - 1 }
        }" 
        x-init="loop()">

        @foreach($concerts->take(5) as $index => $concert)
            <div x-show="activeSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform scale-110"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute inset-0 w-full h-full">
                
                <div class="absolute inset-0 bg-black/50 z-10"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/60 z-10"></div>
                
                <img src="{{ asset('storage/' . $concert->image) }}" 
                     class="w-full h-full object-cover object-center" 
                     alt="{{ $concert->name }}">

                <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-center px-4 mt-16">
                    <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-purple-300 text-xs font-bold tracking-widest uppercase mb-4 animate-pulse">
                        Upcoming Event
                    </span>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 drop-shadow-2xl tracking-tight max-w-4xl leading-tight">
                        {{ $concert->name }}
                    </h1>
                    <div class="flex items-center gap-4 text-gray-200 text-lg mb-8 font-medium">
                        <span class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ \Carbon\Carbon::parse($concert->date)->format('d M Y') }}</span>
                        <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                        <span class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $concert->venue->name }}</span>
                    </div>
                    
                    <a href="{{ route('concert.detail', $concert->id) }}" class="group relative px-8 py-4 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-full shadow-lg shadow-purple-900/50 transition-all transform hover:scale-105 hover:-translate-y-1">
                        <span class="relative z-10 flex items-center gap-2">
                            AMANKAN TIKETMU 🎟️
                        </span>
                    </a>
                </div>
            </div>
        @endforeach

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-30 flex space-x-3">
            @foreach($concerts->take(5) as $index => $concert)
                <button @click="activeSlide = {{ $index }}" 
                        :class="activeSlide === {{ $index }} ? 'bg-purple-500 w-10 scale-110' : 'bg-white/30 w-3 hover:bg-white'" 
                        class="h-3 rounded-full transition-all duration-500"></button>
            @endforeach
        </div>
    </section>

    <section class="container mx-auto px-4 py-20">
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-4">
            <div>
                <h3 class="text-3xl font-extrabold text-white mb-2 flex items-center gap-3">
                    <span class="w-2 h-10 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></span>
                    Event Terbaru
                </h3>
                <p class="text-gray-400">Jangan sampai kehabisan tiket musisi favoritmu!</p>
            </div>
            <a href="#" class="text-purple-400 hover:text-white font-semibold transition border-b border-purple-400 hover:border-white pb-1">Lihat Semua Event →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($concerts as $concert)
            <div class="bg-gray-900/50 border border-gray-800 rounded-2xl overflow-hidden hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-900/20 transition-all duration-300 group">
                
                <a href="{{ route('concert.detail', $concert->id) }}" class="block relative h-64 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10 opacity-60 group-hover:opacity-40 transition"></div>
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                         src="{{ $concert->image ? asset('storage/'.$concert->image) : 'https://placehold.co/600x400/222/FFF?text=Event' }}" 
                         alt="Concert Image">
                    
                    <div class="absolute top-4 right-4 z-20 bg-white/10 backdrop-blur-md border border-white/20 text-white text-center px-3 py-2 rounded-xl">
                        <span class="block text-xs font-bold uppercase text-gray-300">{{ \Carbon\Carbon::parse($concert->date)->format('M') }}</span>
                        <span class="block text-xl font-extrabold text-purple-400">{{ \Carbon\Carbon::parse($concert->date)->format('d') }}</span>
                    </div>
                </a>

                <div class="p-6 relative">
                    <div class="absolute -top-6 left-6 z-20">
                        <span class="bg-purple-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                            {{ $concert->ticketCategories->count() }} Kategori
                        </span>
                    </div>

                    <a href="{{ route('concert.detail', $concert->id) }}">
                        <h5 class="mb-3 text-xl font-bold text-white leading-tight hover:text-purple-400 transition line-clamp-2">
                            {{ $concert->name }}
                        </h5>
                    </a>
                    
                    <p class="mb-6 font-medium text-gray-400 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $concert->venue->name }}
                    </p>
                    
                    <div class="border-t border-gray-800 pt-4 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 mb-1">Mulai dari</span>
                            <span class="text-white font-bold text-lg">Rp {{ number_format($concert->ticketCategories->min('price') ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('concert.detail', $concert->id) }}" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-purple-400 hover:bg-purple-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <footer class="bg-black border-t border-gray-900 py-12">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" class="h-8 w-auto grayscale opacity-50 hover:opacity-100 transition" alt="Logo">
                <span class="text-gray-500 font-bold">TICKIFY</span>
            </div>
            <div class="text-gray-600 text-sm">
                &copy; 2025 Tickify Indonesia. Dibuat dengan 💜 dan Kopi.
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-600 hover:text-white transition">Instagram</a>
                <a href="#" class="text-gray-600 hover:text-white transition">Twitter</a>
                <a href="#" class="text-gray-600 hover:text-white transition">Facebook</a>
            </div>
        </div>
    </footer>

</body>
</html>