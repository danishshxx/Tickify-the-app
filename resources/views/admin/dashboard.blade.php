<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase">Total Pendapatan</h3>
                    <p class="text-3xl font-bold text-green-400 mt-2">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase">Tiket Terjual</h3>
                    <p class="text-3xl font-bold text-purple-400 mt-2">{{ $totalTransactions }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase">Total Konser</h3>
                    <p class="text-3xl font-bold text-blue-400 mt-2">{{ $totalConcerts }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase">Venue Aktif</h3>
                    <p class="text-3xl font-bold text-yellow-400 mt-2">{{ $totalVenues }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-white">Daftar Event / Konser</h3>
                <a href="{{ route('concerts.create') }}" class="text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-purple-800/80">
                    + Tambah Konser Baru
                </a>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-800">
                <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-900 border-b border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Event</th>
                            <th scope="col" class="px-6 py-3">Tanggal & Venue</th>
                            <th scope="col" class="px-6 py-3">Kategori Tiket</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($concerts as $concert)
                        <tr class="bg-black border-b border-gray-800 hover:bg-gray-900 transition">
                            <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap flex items-center gap-3">
                                @if($concert->image)
                                    <img src="{{ asset('storage/'.$concert->image) }}" class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-700 rounded flex items-center justify-center">📷</div>
                                @endif
                                {{ $concert->name }}
                            </th>
                            
                            <td class="px-6 py-4">
                                <div class="text-white font-bold">{{ \Carbon\Carbon::parse($concert->date)->format('d M Y') }}</div>
                                <div class="text-xs">{{ $concert->venue->name }}</div>
                            </td>

                            <td class="px-6 py-4">
                                @php $ticketCount = $concert->ticketCategories->count(); @endphp
                                @if($ticketCount > 0)
                                    <span class="bg-green-900 text-green-300 text-xs font-medium px-2.5 py-0.5 rounded border border-green-700">Available: {{ $ticketCount }} Jenis</span>
                                @else
                                    <span class="bg-red-900 text-red-300 text-xs font-medium px-2.5 py-0.5 rounded border border-red-700">Belum ada Tiket</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center space-x-2 flex justify-center items-center">
                                
                                <a href="{{ route('concerts.tickets.create', $concert->id) }}" class="font-medium text-blue-400 hover:underline">
                                    Atur Tiket
                                </a>

                                <span class="text-gray-600">|</span>

                                <a href="{{ route('concerts.edit', $concert->id) }}" class="font-medium text-yellow-400 hover:underline">
                                    Edit
                                </a>

                                <span class="text-gray-600">|</span>

                                <form action="{{ route('concerts.destroy', $concert->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus konser ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-500 hover:underline bg-transparent border-0 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>