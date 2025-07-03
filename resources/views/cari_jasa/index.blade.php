<x-app-layout>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-purple-50 via-white to-purple-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-500 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold text-blue-800 mb-4">
                    Skill <span class="text-purple-500">Warga</span>
                </h1>
                <p class="text-xl text-blue-400 max-w-2xl mx-auto">
                    Temukan jasa yang Anda inginkan!
                </p>
            </div>
    <div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Jasa') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('cari_jasa.create') }}"
               class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                + Tambah Jasa
            </a>

            

        </div>      
    </div>

    

</x-app-layout>
