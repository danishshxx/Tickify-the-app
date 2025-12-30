<x-app-layout>
    <div class="py-12 bg-black min-h-screen flex justify-center items-center">
        
        <div class="bg-gray-900 border border-purple-500 rounded-3xl p-8 max-w-md w-full shadow-2xl shadow-purple-900/50 relative overflow-hidden">
            
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-600 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-600 rounded-full blur-3xl opacity-50"></div>

            <div class="text-center relative z-10">
                <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 mb-2">E-TICKET</h2>
                <p class="text-gray-400 text-sm">Tunjukkan kode ini saat masuk venue</p>
            </div>

            <div class="my-8 bg-white p-4 rounded-xl">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=TICKIFY-{{ $transaction->id }}-{{ $transaction->user->email }}" 
                     class="w-full h-auto rounded-lg mx-auto" alt="QR Code">
            </div>

            <div class="space-y-4 text-white relative z-10">
                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Event</span>
                    <span class="font-bold text-right">{{ $transaction->ticketCategory->concert->name }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Jadwal</span>
                    <span class="font-bold text-right">{{ \Carbon\Carbon::parse($transaction->ticketCategory->concert->date)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Kategori</span>
                    <span class="font-bold text-purple-400">{{ $transaction->ticketCategory->type }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Pemegang Tiket</span>
                    <span class="font-bold">{{ $transaction->user->name }}</span>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('dashboard') }}" class="block w-full text-center bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 rounded-xl transition">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>

    </div>
</x-app-layout>