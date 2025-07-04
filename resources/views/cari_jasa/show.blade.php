<x-app-layout>
    <div class="bg-gradient-to-br from-purple-50 via-white to-purple-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('jasa.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Jasa
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Image Section -->
                <div class="space-y-4">
                    <div class="relative h-96 bg-gradient-to-br from-purple-400 to-blue-500 rounded-2xl overflow-hidden">
                        @if($jasa->gambar)
                            <img src="{{ $jasa->gambar_url }}" alt="{{ $jasa->nama_jasa }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Kategori Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 text-purple-600 text-sm font-medium px-3 py-1 rounded-full">
                                {{ $jasa->kategori }}
                            </span>
                        </div>

                        <!-- Status Badge (Admin Only) -->
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <div class="absolute top-4 right-4">
                                    <span class="bg-{{ $jasa->status === 'aktif' ? 'green' : 'red' }}-500 text-white text-sm font-medium px-3 py-1 rounded-full">
                                        {{ ucfirst($jasa->status) }}
                                    </span>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Admin Actions -->
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Admin</h3>
                                <div class="flex space-x-3">
                                    <a href="{{ route('jasa.edit', $jasa) }}" 
                                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded-lg transition duration-200">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <form method="POST" action="{{ route('jasa.toggle-status', $jasa) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-{{ $jasa->status === 'aktif' ? 'yellow' : 'green' }}-500 hover:bg-{{ $jasa->status === 'aktif' ? 'yellow' : 'green' }}-600 text-white py-2 px-4 rounded-lg transition duration-200">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            {{ $jasa->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('jasa.destroy', $jasa) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus jasa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition duration-200">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Detail Section -->
                <div class="space-y-6">
                    <!-- Main Info -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $jasa->nama_jasa }}</h1>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-6 p-4 bg-purple-50 rounded-lg">
                            <div>
                                <span class="text-3xl font-bold text-purple-600">
                                    Rp {{ number_format($jasa->harga, 0, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-600 ml-2">/ {{ $jasa->satuan }}</span>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-lg">{{ $jasa->lokasi }}</span>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $jasa->deskripsi }}</p>
                        </div>

                        <!-- Meta Information -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <span class="text-sm text-gray-500">Dibuat pada</span>
                                <p class="font-medium text-gray-800">{{ $jasa->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Terakhir update</span>
                                <p class="font-medium text-gray-800">{{ $jasa->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Provider Info -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Penyedia Jasa</h3>
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 text-lg">{{ $jasa->nama_penyedia }}</h4>
                                <p class="text-gray-600">{{ $jasa->kontak }}</p>
                            </div>
                        </div>

                        <!-- Contact Actions -->
                        <div class="mt-6 space-y-3">
                            @php
                                $contact = $jasa->kontak;
                                $isPhone = preg_match('/^[\+]?[0-9\-\s\(\)]+$/', $contact);
                                $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);
                            @endphp

                            @if($isPhone)
                                <a href="tel:{{ preg_replace('/[^0-9\+]/', '', $contact) }}" 
                                   class="flex items-center justify-center w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Hubungi via Telepon
                                </a>
                                
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_replace('+', '', $contact)) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                    Hubungi via WhatsApp
                                </a>
                            @elseif($isEmail)
                                <a href="mailto:{{ $contact }}" 
                                   class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Kirim Email
                                </a>
                            @else
                                <div class="flex items-center justify-center w-full bg-gray-100 text-gray-600 py-3 px-4 rounded-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Hubungi: {{ $contact }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Actions -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                        
                        <div class="space-y-3">
                            <button onclick="window.print()" 
                                    class="flex items-center justify-center w-full bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Cetak Detail
                            </button>
                            
                            <button onclick="shareJasa()" 
                                    class="flex items-center justify-center w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 px-4 rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Bagikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareJasa() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $jasa->nama_jasa }}',
                    text: '{{ $jasa->deskripsi }}',
                    url: window.location.href
                });
            } else {
                // Fallback untuk browser yang tidak mendukung Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link berhasil disalin ke clipboard!');
                });
            }
        }
    </script>
</x-app-layout>