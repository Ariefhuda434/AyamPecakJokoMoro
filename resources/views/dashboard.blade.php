@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-gray-100 p-6 md:p-10 font-alata">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-500">Rekap Penjualan</h3>
                <span class="text-2xl font-bold text-blue-500">📈</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">Rp 9.000.000,00</p>
            <p class="text-sm text-gray-500 mb-4">25 November 2025</p>
            <div class="h-8 flex space-x-0.5 opacity-70">
                @for ($i = 0; $i < 15; $i++)
                    <div class="w-1 bg-green-500 rounded-sm" style="height: {{ rand(30, 90) }}%;"></div>
                @endfor
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-500">Pendapatan Bulanan</h3>
                <span class="text-2xl font-bold text-green-500">💰</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">Rp 125.752.350,00</p>
            <p class="text-sm text-gray-500 mb-4">1 Nov - 1 Des</p>
            <div class="h-8 flex space-x-0.5 opacity-70">
                @for ($i = 0; $i < 15; $i++)
                    <div class="w-1 bg-blue-400 rounded-sm" style="height: {{ rand(30, 90) }}%;"></div>
                @endfor
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-500">Meja Terpakai</h3>
                <span class="text-2xl font-bold text-red-500">🪑</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">25 Meja</p>
            <p class="text-sm text-gray-500 mb-4 invisible">Placeholder Text</p>
            <div class="h-8 flex space-x-0.5 opacity-70">
                @for ($i = 0; $i < 15; $i++)
                    <div class="w-1 bg-red-400 rounded-sm" style="height: {{ rand(30, 90) }}%;"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- BAGIAN DETAIL (LEBIH TERANG) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

        {{-- Hidangan Populer --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Hidangan Populer</h2>
                <button class="text-sm font-semibold text-white bg-blue-600 px-3 py-1 rounded-full hover:bg-blue-700 transition">Lihat Semua</button>
            </div>

            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center py-3 border-b border-gray-200 last:border-b-0">
                    <img src="https://via.placeholder.com/60" alt="Ayam Goreng Pecak" class="w-16 h-16 object-cover rounded-lg mr-4 shadow-sm">
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-900">Ayam Goreng Pecak</p>
                        <p class="text-sm text-gray-500">Porsi: 01 orang</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-green-600 font-semibold">Tersedia</p>
                        <p class="text-base font-bold text-gray-900">Rp 15.000</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Menu → Resep</h2>
                <form action="{{ route('menu.index') }}" method="get">
                    <button type="submit" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">Selengkapnya</button>
                </form>
            </div>

            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center py-3 border-b border-gray-200 last:border-b-0">
                    <img src="https://via.placeholder.com/60" alt="Ayam Goreng Pecak" class="w-16 h-16 object-cover rounded-lg mr-4 shadow-sm">
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-900">Ayam Goreng Pecak</p>
                        <p class="text-base font-bold text-gray-900">Rp 15.000</p>
                        <p class="text-sm text-green-600 font-semibold">Tersedia</p>
                    </div>
                    <button class="text-gray-500 hover:text-blue-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>
            @endfor
        </div>
    </div>

    {{-- BAGIAN GRAFIK DAN RINGKASAN --}}
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900">Ringkasan</h2>
            <div class="flex items-center space-x-3">
                {{-- Tombol Periode --}}
                <div class="bg-gray-100 p-1 rounded-lg flex space-x-1">
                    <button class="px-4 py-1 text-sm font-semibold bg-blue-600 text-white rounded-lg transition">Bulanan</button>
                    <button class="px-4 py-1 text-sm font-semibold text-gray-600 hover:bg-white rounded-lg transition">Harian</button>
                    <button class="px-4 py-1 text-sm font-semibold text-gray-600 hover:bg-white rounded-lg transition">Mingguan</button>
                </div>
                {{-- Tombol Export --}}
                <button class="flex items-center text-sm font-semibold text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    Export
                </button>
            </div>
        </div>

        {{-- Legenda Grafik --}}
        <div class="flex space-x-4 mb-4">
            <div class="flex items-center text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                Penjualan
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                Pendapatan
            </div>
        </div>

        {{-- Placeholder Grafik --}}
        <div class="h-64">
             {{-- Ganti URL background image dengan yang memiliki skema warna terang atau hapus jika ingin menggunakan chart library sesungguhnya --}}
            <img src="https://via.placeholder.com/800x350/E5E5E5/000000?text=Chart+Placeholder" alt="Grafik Penjualan dan Pendapatan" class="w-full h-full object-cover rounded-lg" style="opacity: 1; border: 1px solid #ccc;">
        </div>
        
        {{-- Label Bulan --}}
        <div class="flex justify-between mt-4 text-xs text-gray-500">
            <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MAY</span><span>JUN</span><span>JUL</span><span>AUG</span><span>SEP</span><span>OCT</span><span>NOV</span><span>DEC</span>
        </div>
    </div>
</div>

@endsection