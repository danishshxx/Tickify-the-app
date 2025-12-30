<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Atur Tiket: <span class="text-purple-400">{{ $concert->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">

                    <h3 class="text-lg font-bold mb-4">Tiket yang sudah ada:</h3>
                    @if($concert->ticketCategories->count() > 0)
                        <ul class="mb-8 space-y-2">
                            @foreach($concert->ticketCategories as $ticket)
                                <li class="bg-black p-3 rounded border border-gray-700 flex justify-between items-center">
                                    <span>
                                        <span class="font-bold text-purple-400">{{ $ticket->type }}</span> 
                                        - Stok: {{ $ticket->total_qty }}
                                    </span>
                                    <span class="font-mono">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 mb-8 italic">Belum ada kategori tiket. Silakan tambah di bawah.</p>
                    @endif

                    <hr class="border-gray-700 mb-8">

                    <h3 class="text-lg font-bold mb-4 text-purple-400">+ Tambah Kategori Baru</h3>
                    
                    <form action="{{ route('concerts.tickets.store', $concert->id) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-300">Nama Kategori</label>
                                <input type="text" name="type" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" placeholder="Misal: VIP, Festival A" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-300">Harga (Rupiah)</label>
                                <input type="number" name="price" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" placeholder="500000" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-300">Stok Tiket</label>
                                <input type="number" name="total_qty" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" placeholder="100" required>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 bg-transparent border border-gray-600 hover:bg-gray-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Selesai / Kembali
                            </a>
                            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-green-900/50">
                                + Simpan Tiket
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>