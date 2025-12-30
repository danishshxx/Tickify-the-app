<x-app-layout>
    <div class="py-12 bg-black min-h-screen flex justify-center items-center">
        
        <div class="bg-gray-900 border border-gray-800 max-w-sm w-full rounded-2xl shadow-2xl shadow-purple-900/20 overflow-hidden relative">
            
            <div class="bg-gradient-to-r from-purple-900 to-purple-600 p-6 text-center text-white">
                <h2 class="text-xl font-bold uppercase tracking-wider">Selesaikan Pembayaran</h2>
                <p class="text-purple-200 text-sm mt-1">Order ID: #{{ $transaction->id }}</p>
            </div>

            <div class="p-6 text-center">
                
                @php
                    // Biaya Admin kita set manual 5000 (sesuai controller)
                    $adminFee = 5000;
                    
                    // Rumus: Total = (Subtotal x 1.11) + Admin
                    // Jadi: Subtotal = (Total - Admin) / 1.11
                    $subtotal = ($transaction->total_price - $adminFee) / 1.11;
                    $tax = $subtotal * 0.11;
                @endphp

                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4 mb-6 text-sm">
                    <h3 class="text-gray-300 font-bold mb-3 text-left border-b border-gray-700 pb-2">Rincian Biaya</h3>
                    
                    <div class="flex justify-between mb-2 text-gray-400">
                        <span>Tiket (x{{ $transaction->qty }})</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between mb-2 text-gray-400">
                        <span>PPN (11%)</span>
                        <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between mb-2 text-gray-400">
                        <span>Biaya Layanan</span>
                        <span>Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="border-t border-gray-700 mt-2 pt-2 flex justify-between items-center">
                        <span class="text-gray-200 font-bold">TOTAL BAYAR</span>
                        <span class="text-xl font-extrabold text-purple-400">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-2 mb-4 inline-block shadow-lg">
                    <img src="{{ asset('qris.png') }}" alt="Scan QRIS" class="w-64 h-64 object-contain">
                </div>

                <p class="text-xs text-gray-400 mb-6 px-4 leading-relaxed">
                    Scan QRIS di atas menggunakan GoPay, OVO, Dana, ShopeePay atau Mobile Banking apa saja.
                </p>

                <div class="bg-gray-800 border border-gray-700 rounded-lg p-4 text-left text-sm space-y-3 mb-6">
                    <div class="flex justify-between items-start">
                        <span class="text-gray-400 shrink-0">Event</span>
                        <span class="font-bold text-white text-right break-words pl-4 line-clamp-2">
                            {{ $transaction->ticketCategory->concert->name }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Kategori</span>
                        <span class="font-bold text-purple-400">
                            {{ $transaction->ticketCategory->type }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-green-900/50 transform hover:scale-[1.02]">
                    ✅ SAYA SUDAH BAYAR
                </a>
                
                <p class="text-[10px] text-gray-500 mt-4">
                    Mohon selesaikan pembayaran sebelum tiket hangus. <br>
                    Setelah bayar, upload bukti transfer di menu Dashboard.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>