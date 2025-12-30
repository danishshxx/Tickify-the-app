<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tiket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    
                    <h3 class="text-2xl font-bold mb-6 flex items-center">
                        🎟️ Riwayat Pembelian Tiket
                    </h3>

                    @if($transactions->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-700">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                                <thead class="text-xs text-gray-400 uppercase bg-gray-800 border-b border-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ID Transaksi</th>
                                        <th scope="col" class="px-6 py-3">Event / Konser</th>
                                        <th scope="col" class="px-6 py-3">Kategori</th>
                                        <th scope="col" class="px-6 py-3">Jumlah</th>
                                        <th scope="col" class="px-6 py-3">Total Harga</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                        <th scope="col" class="px-6 py-3">Tanggal Beli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $trx)
                                    <tr class="bg-gray-900 border-b border-gray-800 hover:bg-gray-800 transition">
                                        <td class="px-6 py-4 font-mono text-xs">#{{ $trx->id }}</td>
                                        <td class="px-6 py-4 font-bold text-white">
                                            {{ $trx->ticketCategory->concert->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-900 text-purple-300 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-700">
                                                {{ $trx->ticketCategory->type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $trx->total_tickets }} Tiket</td>
                                        <td class="px-6 py-4 font-bold text-green-400">
                                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($trx->status == 'paid')
                                                <a href="{{ route('ticket.show', $trx->id) }}" class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded transition shadow-lg shadow-green-900/50">
                                                    🎟️ LIHAT E-TICKET
                                                </a>
                                            @elseif($trx->status == 'rejected')
                                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">DITOLAK ❌</span>
                                            @else
                                                @if(!$trx->payment_proof)
                                                    <span class="block mb-2 text-yellow-500 text-xs font-bold">Menunggu Pembayaran</span>
                                                    
                                                    <form action="{{ route('transactions.upload', $trx->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="file" name="payment_proof" class="text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-900 file:text-purple-300 hover:file:bg-purple-800" required>
                                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-2 py-1 roundedmt-1">Kirim Bukti 📤</button>
                                                    </form>
                                                @else
                                                    <span class="text-blue-400 text-xs font-bold">Sedang Diverifikasi Admin ⏳</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs">
                                            {{ $trx->created_at->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="mb-4 text-6xl">😢</div>
                            <h4 class="text-xl font-bold text-gray-300 mb-2">Kamu belum punya tiket nih!</h4>
                            <p class="text-gray-500 mb-6">Yuk cari konser seru dan amankan tiketmu sekarang.</p>
                            <a href="{{ route('home') }}" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-900 font-medium rounded-lg text-sm px-5 py-2.5">
                                Cari Konser
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>