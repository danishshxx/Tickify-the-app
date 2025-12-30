<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Konser Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    
                    @if ($errors->any())
                        <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                            <div class="font-bold">Waduh! Ada yang salah nih:</div>
                            <ul class="list-disc list-inside mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('concerts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-300">Nama Event / Artis</label>
                            <input type="text" name="name" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" placeholder="Contoh: Coldplay Music of Spheres" required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-300">Deskripsi Event</label>
                            <textarea name="description" rows="4" class="block p-2.5 w-full text-sm text-white bg-gray-800 rounded-lg border border-gray-700 focus:ring-purple-500 focus:border-purple-500" placeholder="Tulis detail konser di sini..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-300">Tanggal Konser</label>
                                <input type="date" name="date" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-300">Lokasi Venue</label>
                                <select name="venue_id" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Venue belum ada? Tambah via database dulu ya.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-300">Poster / Banner (Landscape)</label>
                            <input class="block w-full text-sm text-gray-400 border border-gray-700 rounded-lg cursor-pointer bg-gray-800 focus:outline-none" name="image" type="file" required>
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG (Max 40MB).</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                Simpan & Publish Konser
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>