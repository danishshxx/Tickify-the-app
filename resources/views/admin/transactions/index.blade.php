<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Validasi Pembayaran</h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold text-white mb-4">Daftar Transaksi Masuk</h3>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-800">
                            <tr>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Tiket & Jumlah</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Bukti Bayar</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $trx)
                            <tr class="bg-gray-900 border-b border-gray-800 hover:bg-gray-850">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white">{{ $trx->user->name }}</div>
                                    <div class="text-xs">{{ $trx->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $trx->ticketCategory->concert->name }}
                                    <br>
                                    <span class="text-purple-400">
                                        {{ $trx->ticketCategory->type }} (x{{ $trx->qty }})
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-white">Rp {{ number_format($trx->total_price) }}</td>
                                <td class="px-6 py-4">
                                    @if($trx->payment_proof)
                                        <a href="{{ asset('storage/'.$trx->payment_proof) }}" target="_blank" class="inline-flex items-center px-3 py-1 text-xs text-blue-400 border border-blue-400 rounded hover:bg-blue-900">
                                            👁️ Lihat Foto
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">Belum upload</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($trx->status == 'paid') <span class="text-green-400 font-bold">LUNAS</span>
                                    @elseif($trx->status == 'rejected') <span class="text-red-400 font-bold">DITOLAK</span>
                                    @elseif($trx->payment_proof) <span class="text-blue-400 font-bold">BUTUH VERIFIKASI</span>
                                    @else <span class="text-yellow-500">Menunggu User</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    @if($trx->status == 'pending' && $trx->payment_proof)
                                        <form action="{{ route('admin.transactions.confirm', $trx->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold">✔ TERIMA</button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold" onclick="return confirm('Yakin tolak?');">✖ TOLAK</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>