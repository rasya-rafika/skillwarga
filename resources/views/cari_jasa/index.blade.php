<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-purple-50 via-white to-purple-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-500 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2"></path>
                    </svg>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold text-blue-800 mb-4">
                    Skill <span class="text-purple-500">Warga</span>
                </h1>
                <p class="text-xl text-blue-400 max-w-2xl mx-auto">
                    Temukan jasa yang Anda butuhkan dari warga sekitar
                </p>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('jasa.index') }}" class="space-y-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari jasa atau deskripsi..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Kategori Filter -->
                        <div>
                            <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lokasi Filter -->
                        <div>
                            <select name="lokasi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Semua Lokasi</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                        {{ $lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Filter -->
                        <div>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div>
                            <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Count -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-gray-600">
                    Menampilkan {{ $jasas->count() }} dari {{ $jasas->total() }} jasa
                </div>
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('jasa.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            + Tambah Jasa
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Jasa Cards Grid -->
            @if($jasas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($jasas as $jasa)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Image -->
                            <div class="relative h-48 bg-gradient-to-br from-purple-400 to-blue-500">
                                @if($jasa->gambar)
                                    <img src="{{ $jasa->gambar_url }}" alt="{{ $jasa->nama_jasa }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Kategori Badge -->
                                <div class="absolute top-3 left-3">
                                    <span class="bg-white/90 text-purple-600 text-xs font-medium px-2 py-1 rounded-full">
                                        {{ $jasa->kategori }}
                                    </span>
                                </div>

                                <!-- Status Badge (Admin Only) -->
                                @auth
                                    @if(auth()->user()->hasRole('admin'))
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-{{ $jasa->status === 'aktif' ? 'green' : 'red' }}-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                                {{ ucfirst($jasa->status) }}
                                            </span>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                    {{ $jasa->nama_jasa }}
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $jasa->deskripsi }}
                                </p>

                                <!-- Location -->
                                <div class="flex items-center text-gray-500 text-sm mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $jasa->lokasi }}
                                </div>

                                <!-- Price -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-purple-600">
                                        Rp {{ number_format($jasa->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $jasa->satuan }}
                                    </span>
                                </div>

                                <!-- Provider Info -->
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">{{ $jasa->nama_penyedia }}</p>
                                        <p class="text-xs text-gray-500">{{ $jasa->kontak }}</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('jasa.show', $jasa) }}" 
                                       class="flex-1 bg-purple-500 hover:bg-purple-600 text-white text-center py-2 px-4 rounded-lg transition duration-200 text-sm font-medium">
                                        Lihat Detail
                                    </a>
                                    
                                    @auth
                                        @if(auth()->user()->hasRole('admin'))
                                            <a href="{{ route('jasa.edit', $jasa) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg transition duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <form method="POST" action="{{ route('jasa.toggle-status', $jasa) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="bg-{{ $jasa->status === 'aktif' ? 'yellow' : 'green' }}-500 hover:bg-{{ $jasa->status === 'aktif' ? 'yellow' : 'green' }}-600 text-white py-2 px-3 rounded-lg transition duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <form method="POST" action="{{ route('jasa.destroy', $jasa) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus jasa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg transition duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $jasas->appends(request()->query())->links() }}
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada jasa ditemukan</h3>
                    <p class="text-gray-500 mb-6">Coba ubah filter pencarian atau kata kunci Anda.</p>
                    <a href="{{ route('jasa.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Lihat Semua Jasa
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>