@extends('layouts.app')

@section('title','dashboard')

@section('content')

<div>
    <div class="min-h-screen bg-[#421512] text-white p-6 md:p-10 font-alata">
    <header class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <div class="flex items-center space-x-4">
            <div class="relative w-8 h-8 flex items-center justify-center rounded-full bg-transparent">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-[#421512] bg-red-500"></span>
            </div>
            <div class="relative w-8 h-8 flex items-center justify-center rounded-full bg-transparent">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h.01a1 1 0 100-2H10v-3a1 1 0 00-1-1zm6.5 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd"></path></svg>
            </div>
            <img src="https://via.placeholder.com/40/FFD700/000000?text=👤" alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-yellow-500 object-cover">
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-[#2C2C2C] p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-400">Rekap Penjualan</h3>
                <span class="text-2xl font-bold text-yellow-500">$</span>
            </div>
            <p class="text-3xl font-bold mb-1">Rp 9.000.000,00</p>
            <p class="text-sm text-gray-400 mb-4">25 November 2025</p>
            <div class="h-8 flex space-x-0.5 opacity-70">
                @for ($i = 0; $i < 15; $i++)
                    <div class="w-1 bg-green-500 rounded-sm" style="height: {{ rand(30, 90) }}%;"></div>
                @endfor
            </div>
        </div>

        <div class="bg-[#2C2C2C] p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-400">Pendapatan Bulanan</h3>
                <span class="text-2xl font-bold text-yellow-500">💰</span>
            </div>
            <p class="text-3xl font-bold mb-1">Rp 125.752.350,00</p>
            <p class="text-sm text-gray-400 mb-4">1 Nov - 1 Des</p>
            <div class="h-8 flex space-x-0.5 opacity-70">
                @for ($i = 0; $i < 15; $i++)
                    <div class="w-1 bg-white rounded-sm" style="height: {{ rand(30, 90) }}%;"></div>
                @endfor
            </div>
        </div>

        <div class="bg-[#2C2C2C] p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-400">Meja Terpakai</h3>
                <span class="text-2xl font-bold text-yellow-500">🪑</span>
            </div>
            <p class="text-3xl font-bold mb-1">25 Meja</p>
            <p class="text-sm text-gray-400 mb-4 invisible">Placeholder Text</p>
            <div class="h-8 flex space-x-0.5 opacity-70">
                @for ($i = 0; $i < 15; $i++)
                    <div class="w-1 bg-red-500 rounded-sm" style="height: {{ rand(30, 90) }}%;"></div>
                @endfor
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

        <div class="bg-[#2C2C2C] p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Hidangan Populer</h2>
                <button class="text-sm font-semibold text-yellow-500 bg-[#3A3A3A] px-3 py-1 rounded-full hover:bg-[#4A4A4A]">Lihat Semua</button>
            </div>

            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center py-3 border-b border-[#3A3A3A] last:border-b-0">
                    <img src="https://via.placeholder.com/60" alt="Ayam Goreng Pecak" class="w-16 h-16 object-cover rounded-lg mr-4">
                    <div class="flex-grow">
                        <p class="font-semibold">Ayam Goreng Pecak</p>
                        <p class="text-sm text-gray-400">Porsi: 01 orang</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-green-500 font-semibold">Tersedia</p>
                        <p class="text-base font-bold">Rp 15.000</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="bg-[#2C2C2C] p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Menu → Resep</h2>
                <button class="text-sm font-semibold text-yellow-500 hover:text-white">Selengkapnya</button>
            </div>

            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center py-3 border-b border-[#3A3A3A] last:border-b-0">
                    <img src="https://via.placeholder.com/60" alt="Ayam Goreng Pecak" class="w-16 h-16 object-cover rounded-lg mr-4">
                    <div class="flex-grow">
                        <p class="font-semibold">Ayam Goreng Pecak</p>
                        <p class="text-base font-bold">Rp 15.000</p>
                        <p class="text-sm text-green-500 font-semibold">Tersedia</p>
                    </div>
                    <button class="text-gray-400 hover:text-yellow-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>
            @endfor
        </div>
    </div>

    <div class="bg-[#2C2C2C] p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Ringkasan</h2>
            <div class="flex items-center space-x-3">
                <div class="bg-[#3A3A3A] p-1 rounded-lg flex space-x-1">
                    <button class="px-4 py-1 text-sm font-semibold bg-yellow-500 text-black rounded-lg">Bulanan</button>
                    <button class="px-4 py-1 text-sm font-semibold text-white hover:bg-[#4A4A4A] rounded-lg">Harian</button>
                    <button class="px-4 py-1 text-sm font-semibold text-white hover:bg-[#4A4A4A] rounded-lg">Mingguan</button>
                </div>
                <button class="flex items-center text-sm font-semibold text-yellow-500 bg-[#3A3A3A] px-4 py-2 rounded-lg hover:bg-[#4A4A4A]">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    Export
                </button>
            </div>
        </div>

        <div class="flex space-x-4 mb-4">
            <div class="flex items-center text-sm">
                <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                Penjualan
            </div>
            <div class="flex items-center text-sm">
                <span class="w-3 h-3 rounded-full bg-white mr-2"></span>
                Pendapatan
            </div>
        </div>

        <div class="h-64">
            <img src="https://via.placeholder.com/800x350/2C2C2C/FFFFFF?text=Chart+Placeholder" alt="Grafik Penjualan dan Pendapatan" class="w-full h-full object-cover rounded-lg opacity-0" style="background-image: url('https://i.imgur.com/rLz8R6N.png'); background-size: cover; background-position: center;">
                        </div>
        <div class="flex justify-between mt-4 text-xs text-gray-400">
             <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MAY</span><span>JUN</span><span>JUL</span><span>AUG</span><span>SEP</span><span>OCT</span><span>NOV</span><span>DEC</span>
        </div>
    </div>

</div>
</div>

@endsection