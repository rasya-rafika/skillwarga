<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-house-user text-white text-lg"></i>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <i class="fas fa-calendar-day mr-1"></i> {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- 🎉 Welcome Section -->
            <div class="bg-gradient-to-r from-pink-400 to-purple-500 text-white p-8 rounded-2xl shadow-lg">
                <h2 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name ?? 'Admin' }}! 👋</h2>
                <p class="text-purple-100 text-sm">Selamat datang di <strong>Skill Warga</strong> — platform digital untuk menemukan dan menawarkan jasa dari warga sekitar.</p>
                <div class="mt-4 flex space-x-4 text-sm">
                    <span><i class="fas fa-circle text-green-400 mr-1 text-xs"></i> Status: Aktif</span>
                </div>
            </div>

            <!-- ℹ️ Tentang Skill Warga -->
            <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
                <h3 class="text-2xl font-semibold text-purple-700 mb-4">Apa itu Skill Warga?</h3>
                <p class="text-gray-700 leading-relaxed text-sm">
                    <strong>Skill Warga</strong> adalah platform yang menghubungkan warga satu sama lain melalui layanan berbasis keahlian lokal. Dengan Skill Warga, Anda dapat:
                </p>
                <ul class="list-disc pl-5 mt-3 text-gray-700 text-sm space-y-1">
                    <li>Mencari penyedia jasa dari lingkungan sekitar secara cepat dan mudah.</li>
                    <li>Menawarkan keahlian Anda untuk mendapatkan penghasilan tambahan.</li>
                    <li>Melihat rating, ulasan, dan detail layanan sebelum memesan jasa.</li>
                </ul>
                <p class="mt-4 text-sm text-gray-600 italic">
                    Mari bangun ekonomi lokal dengan saling berbagi keahlian! 💪
                </p>
            </div>

            <!-- Footer Simple -->
            <div class="text-center text-sm text-gray-400 mt-8">
                &copy; {{ date('Y') }} Skill Warga — Dari Warga Untuk Warga.
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</x-app-layout>
