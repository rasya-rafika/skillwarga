<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jasa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('jasa.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.jasa.update', $jasa) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Jasa -->
                        <div>
                            <label for="nama_jasa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jasa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_jasa" 
                                   name="nama_jasa" 
                                   value="{{ old('nama_jasa', $jasa->nama_jasa) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama_jasa') border-red-500 @enderror"
                                   placeholder="Masukkan nama jasa"
                                   required>
                            @error('nama_jasa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                                      placeholder="Masukkan deskripsi jasa"
                                      required>{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grid untuk Kategori dan Lokasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="kategori" 
                                        name="kategori" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kategori') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Teknologi" {{ old('kategori', $jasa->kategori) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                    <option value="Rumah Tangga" {{ old('kategori', $jasa->kategori) == 'Rumah Tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                                    <option value="Pendidikan" {{ old('kategori', $jasa->kategori) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="Kesehatan" {{ old('kategori', $jasa->kategori) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    <option value="Kecantikan" {{ old('kategori', $jasa->kategori) == 'Kecantikan' ? 'selected' : '' }}>Kecantikan</option>
                                    <option value="Transportasi" {{ old('kategori', $jasa->kategori) == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                    <option value="Otomotif" {{ old('kategori', $jasa->kategori) == 'Otomotif' ? 'selected' : '' }}>Otomotif</option>
                                    <option value="Makanan" {{ old('kategori', $jasa->kategori) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="Olahraga" {{ old('kategori', $jasa->kategori) == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                    <option value="Lainnya" {{ old('kategori', $jasa->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="lokasi" 
                                       name="lokasi" 
                                       value="{{ old('lokasi', $jasa->lokasi) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('lokasi') border-red-500 @enderror"
                                       placeholder="Masukkan lokasi (contoh: Jakarta Selatan)"
                                       required>
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" 
                                       id="harga" 
                                       name="harga" 
                                       value="{{ old('harga', $jasa->harga) }}"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('harga') border-red-500 @enderror"
                                       placeholder="0"
                                       min="0"
                                       step="0.01"
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Masukkan harga dalam rupiah (contoh: 50000 untuk Rp 50.000)</p>
                            @error('harga')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div>
                            <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">
                                Kontak <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="kontak" 
                                   name="kontak" 
                                   value="{{ old('kontak', $jasa->kontak) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kontak') border-red-500 @enderror"
                                   placeholder="Masukkan nomor HP/WhatsApp atau email"
                                   required>
                            @error('kontak')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($jasa->gambar)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Saat Ini
                                </label>
                                <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ $jasa->gambar_url }}" alt="{{ $jasa->nama_jasa }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif

                        <!-- New Image -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $jasa->gambar ? 'Ganti Gambar' : 'Gambar Jasa' }}
                            </label>
                            <input type="file" 
                                   id="gambar" 
                                   name="gambar" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('gambar') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status') border-red-500 @enderror"
                                    required>
                                <option value="aktif" {{ old('status', $jasa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $jasa->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex space-x-4 pt-6">
                            <button type="submit" 
                                    class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                                Update Jasa
                            </button>
                            <a href="{{ route('jasa.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Gambar Script -->
    <script>
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (2MB = 2048KB)
                if (file.size > 2048 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    return;
                }
                
                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipe file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                    this.value = '';
                    return;
                }
            }
        });
    </script>
</x-app-layout>