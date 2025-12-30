<x-app-layout>
    <div class="py-12 bg-black min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <div>
                    <img src="{{ asset('storage/'.$concert->image) }}" class="rounded-xl shadow-2xl shadow-purple-900/50 w-full object-cover mb-6">
                    
                    <h1 class="text-4xl font-bold mb-2">{{ $concert->name }}</h1>
                    <div class="flex items-center text-gray-400 mb-6 space-x-4">
                        <span>📅 {{ \Carbon\Carbon::parse($concert->date)->format('d F Y') }}</span>
                        <span>📍 {{ $concert->venue->name }}</span>
                    </div>

                    <p class="text-gray-300 leading-relaxed text-lg">
                        {{ $concert->description }}
                    </p>
                </div>

                <div class="bg-gray-900 border border-gray-800 p-8 rounded-xl shadow-lg h-fit sticky top-10">
                    <h2 class="text-2xl font-bold mb-6 border-b border-gray-700 pb-4">Beli Tiket</h2>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-900/50 border border-red-700 text-red-200 px-4 py-3 rounded text-sm">
                            <strong class="font-bold">Gagal Checkout:</strong>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('concert.checkout', $concert->id) }}" method="POST">
                        @csrf

                        <div class="mb-6 space-y-3">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Kategori</label>
                            
                            @foreach($concert->ticketCategories as $ticket)
                                <label class="flex items-center justify-between p-4 border rounded-lg transition cursor-pointer 
                                    {{ $ticket->total_qty > 0 ? 'border-gray-700 hover:border-purple-500 hover:bg-gray-800' : 'border-gray-800 bg-gray-900 opacity-50 cursor-not-allowed' }}">
                                    
                                    <div class="flex items-center">
                                        <input type="radio" name="ticket_category_id" value="{{ $ticket->id }}" 
                                               class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500" 
                                               required {{ $ticket->total_qty == 0 ? 'disabled' : '' }}>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-white">
                                                {{ $ticket->type }} 
                                                @if($ticket->total_qty == 0) <span class="text-red-500 font-bold ml-2">(SOLD OUT)</span> @endif
                                            </span>
                                            <span class="block text-xs text-gray-500">Sisa Stok: {{ $ticket->total_qty }}</span>
                                        </div>
                                    </div>
                                    <div class="text-purple-400 font-bold">
                                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                    </div>
                                </label>
                            @endforeach

                            @if($concert->ticketCategories->count() == 0)
                                <div class="p-4 bg-red-900/50 border border-red-800 text-red-200 rounded text-center">
                                    Tiket belum tersedia / Habis.
                                </div>
                            @endif
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Jumlah Tiket (Maks. 4)</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="quantity" min="1" max="4" value="1" 
                                       class="bg-gray-800 border border-gray-700 text-white text-lg font-bold text-center rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-24 p-2.5"
                                       oninput="if(this.value > 4) this.value = 4; if(this.value < 1) this.value = 1;">
                                <div class="text-xs text-gray-500 italic leading-tight">
                                    *Maksimal 4 tiket per akun.<br>Demi keamanan & anti-calo.
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 mb-6 border-t border-gray-700 pt-6">
                            <h3 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                                👤 Data Pemilik Tiket
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Lengkap (Sesuai KTP)</label>
                                    <input type="text" name="buyer_name" value="{{ Auth::user()->name }}" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-400 mb-1">Email Aktif</label>
                                        <input type="email" name="buyer_email" value="{{ Auth::user()->email }}" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-400 mb-1">No. WhatsApp</label>
                                        <input type="number" name="buyer_phone" placeholder="0812..." class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Nomor Induk Kependudukan (NIK)</label>
                                    <input type="number" name="buyer_nik" placeholder="16 digit angka KTP" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 tracking-widest" required>
                                    <p class="text-[10px] text-gray-500 mt-1">*Wajib isi NIK valid untuk verifikasi saat masuk venue.</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-lg text-lg px-5 py-3 text-center transition transform hover:scale-105 shadow-lg shadow-purple-900/50">
                            💳 Checkout Sekarang
                        </button>
                        
                        <p class="text-center text-gray-500 text-xs mt-4">
                            Harga belum termasuk PPN 11% & Biaya Layanan.
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>