<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Konser') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded relative">
                        <strong class="font-bold">Waduh!</strong> Ada yang salah input:
                        <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('concerts.update', $concert->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    
                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm font-bold mb-2">Nama Konser</label>
                        <input type="text" name="name" value="{{ old('name', $concert->name) }}" 
                               class="w-full bg-gray-800 text-white rounded border border-gray-700 focus:border-purple-500 focus:ring-purple-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" 
                                  class="w-full bg-gray-800 text-white rounded border border-gray-700 focus:border-purple-500 focus:ring-purple-500" required>{{ old('description', $concert->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Tanggal Konser</label>
                            <input type="date" name="date" value="{{ old('date', $concert->date) }}" 
                                   class="w-full bg-gray-800 text-white rounded border border-gray-700 focus:border-purple-500 focus:ring-purple-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Lokasi (Venue)</label>
                            <select name="venue_id" class="w-full bg-gray-800 text-white rounded border border-gray-700 focus:border-purple-500 focus:ring-purple-500">
                                @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}" {{ $concert->venue_id == $venue->id ? 'selected' : '' }}>
                                        {{ $venue->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-400 text-sm font-bold mb-2">Banner Konser</label>
                        
                        @if($concert->image)
                            <div class="mb-3 p-2 bg-gray-800 rounded border border-gray-700 inline-block">
                                <span class="block text-xs text-gray-500 mb-1">Gambar Saat Ini:</span>
                                <img src="{{ asset('storage/' . $concert->image) }}" alt="Current Banner" class="h-32 w-auto rounded object-cover">
                            </div>
                        @endif

                        <input type="file" name="image" class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-purple-600 file:text-white
                            hover:file:bg-purple-700
                            cursor-pointer bg-gray-800 border border-gray-700 rounded-lg">
                        <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengubah gambar.</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-purple-900/50 transition">
                            💾 Simpan Perubahan
                        </button>
                        
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white text-sm underline">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>