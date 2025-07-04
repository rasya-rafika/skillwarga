<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesan Daftar Jasa') }}
            </h2>
            <a href="{{ route('daftar_jasa.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Jasa Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Nama Jasa') }}
                                </label>
                                <p class="text-lg text-gray-900">{{ $daftar_jasa->nama }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Deskripsi') }}
                                </label>
                                <p class="text-lg text-gray-900">{{ $daftar_jasa->deskripsi }}</p>
                            </div>
                        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Kategori') }}
                                </label>
                                <p class="text-lg text-gray-900">{{ $daftar_jasa->jenis_jasa }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Lokasi') }}
                                </label>
                                <p class="text-lg text-gray-900">{{ $daftar_jasa->alamat }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Kontak') }}
                                </label>
                                <p class="text-lg text-gray-900">{{ $daftar_jasa->telepon }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Status') }}
                                </label>
                                @if($daftar_jasa->is_read)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ __('Sudah Dibaca') }}
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ __('Belum Dibaca') }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Tanggal Dikirim') }}
                                </label>
                                <p class="text-lg text-gray-900">
                                    {{ $daftar_jasa->created_at->format('d F Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>
                        

                        <!-- Right Column - Photo -->
                        <div class="space-y-4">
                            @if($daftar_jasa->gambar)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('Foto Lampiran') }}
                                    </label>
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($daftar_jasa->gambar) }}" 
                                             alt="Gambar" 
                                             class="max-w-full h-auto rounded-lg shadow-lg cursor-pointer"
                                             onclick="showImageModal('{{ Storage::url($daftar_jasa->gambar) }}')">
                                        <p class="text-sm text-gray-500 mt-2">
                                            {{ __('Klik gambar untuk memperbesar') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('Foto Lampiran') }}
                                    </label>
                                    <p class="text-gray-500 italic">{{ __('Tidak ada foto') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            <div class="mt-8 flex flex-wrap gap-3">
                                @if(!$daftar_jasa->is_read)
                                    <form action="{{ route('daftar_jasa.mark-read', $daftar_jasa->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Tandai Sudah Dibaca') }}
                                        </button>
                                    </form>
                                @endif

                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+', '', $daftar_jasa->telepon)) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center w-50 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                    Hubungi via WhatsApp
                                </a>

                                @if($daftar_jasa->photo)
                                    <form action="{{ route('daftar_jasa.gambar.destroy', $daftar_jasa->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus foto ini?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Hapus Foto') }}
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('daftar_jasa.destroy', $daftar_jasa->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Hapus Pesan') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-4 max-w-4xl max-h-screen overflow-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">{{ __('Preview Foto') }}</h3>
                <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <img id="modalImage" src="" alt="Preview" class="max-w-full h-auto">
        </div>
    </div>

    <script>
    // Modal functions
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Auto mark as read when admin views the contact
    @auth
        @if (auth()->user()->hasRole('admin') && !$daftar_jasa->is_read)
            // Optional: Auto mark as read when admin opens the detail
            // Uncomment the lines below if you want this behavior
            /*
            fetch('{{ route('contact.mark-read', $contact->id) }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            });
            */
        @endif
    @endauth
    </script>
</x-app-layout>