@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-gray-50 p-6 md:p-10 font-alata">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-5 rounded-lg shadow-md border-t-4 border-primary transform transition duration-300 hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-medium text-gray-500">Rekap Penjualan Hari Ini</h3>
                <span class="text-xl text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">RP {{ number_format($penjualanHariIni, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">{{ $tanggalHariIni }}</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-md border-t-4 border-primary transform transition duration-300 hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-medium text-gray-500">Pendapatan Bulanan</h3>
                <span class="text-xl text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8v8m0-8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">Rp 125.752.350</p>
            <p class="text-xs text-gray-400">1 Nov - 1 Des</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-md border-t-4 border-primary transform transition duration-300 hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-medium text-gray-500">Meja Terpakai Saat Ini</h3>
                <span class="text-xl text-yellow-600">
                    <svg class="w-6 h-6" fill="primary" stroke="primary" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $mejaTerpakai}} Meja</p>
            <p class="text-xs text-gray-400">Total {{ $mejaTotal }} Meja</p>
        </div>
    </div>
      

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-lg shadow-md transform transition duration-300 hover:scale-105">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-4">
                <h2 class="text-xl font-bold text-gray-800">Aktivitas Log Terbaru</h2>
                <form action="{{ route('log.index') }}">
                    <button type="submit" class="text-sm font-semibold text-gray-600 hover:text-primary transition">Lihat Semua &rarr;</button>
                </form>
            </div>

            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-start py-3 border-b border-gray-100 last:border-b-0">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full mr-4 
                        @if ($i == 0) bg-blue-100 text-blue-600 @elseif ($i == 1) bg-green-100 text-green-600 @elseif ($i == 2) bg-red-100 text-red-600 @else bg-yellow-100 text-yellow-600 @endif
                        ">
                        @if ($i == 0)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10m0-10l8-4-8-4-8 4 8 4z"></path></svg>
                        @elseif ($i == 1)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @elseif ($i == 2)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endif
                    </div>
                    
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-800">
                            @if ($i == 0)
                                Restock Bahan Ayam (50kg)
                            @elseif ($i == 1)
                                Menu Baru Ayam Pecak Special Ditambahkan
                            @elseif ($i == 2)
                                Update Data Karyawan (ID: 005)
                            @else
                                Laporan Keuangan Harian Disusun
                            @endif
                        </p>
                        <p class="text-sm text-gray-500">Oleh: Manager (ID 001)</p>
                    </div>
                    
                    <p class="text-xs text-gray-400">10 min ago</p>
                </div>
            @endfor
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md transform transition duration-300 hover:scale-105">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-4">
                <h2 class="text-xl font-bold text-gray-800">Menu Populer</h2>
                <form action="{{ route('menu.index') }}" method="get">
                    <button type="submit" class="text-sm font-semibold text-gray-600 hover:text-primary transition">Lihat Menu &rarr;</button>
                </form>
            </div>
            @foreach($menuData as $data)    
            <div class="flex items-center py-3 border-b border-gray-100 last:border-b-0">
                <img src="https://via.placeholder.com/60/421512/FFFFFF?text=MP" alt="Menu Populer" class="w-12 h-12 object-cover rounded-md mr-4 shadow-sm">
                <div class="flex-grow">
                    <p class="font-semibold text-gray-800">{{ $data->nama_menu }}</p>
                    <p class="text-sm font-bold text-gray-900">{{ $data->harga }}</p>
                </div>
                <p class="text-sm text-green-600 font-semibold">{{ $data->status_menu }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md transform transition duration-300 hover:scale-105">
        <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-6">
            <h2 class="text-xl font-bold text-gray-800">Ringkasan Penjualan dan Pendapatan</h2>
            <div class="flex items-center space-x-3">
                <div class="bg-gray-100 p-1 rounded-lg flex space-x-1">
                    <button class="px-4 py-1 text-sm font-semibold bg-primary text-white rounded-lg transition">Bulanan</button>
                    <button class="px-4 py-1 text-sm font-semibold text-gray-600 hover:bg-white rounded-lg transition">Mingguan</button>
                    <button class="px-4 py-1 text-sm font-semibold text-gray-600 hover:bg-white rounded-lg transition">Harian</button>
                </div>
                <button class="flex items-center text-sm font-semibold text-white bg-primary px-4 py-2 rounded-lg hover:opacity-90 transition">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    Export
                </button>
            </div>
        </div>

        <div class="flex space-x-6 mb-4">
            <div class="flex items-center text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-primary mr-2"></span>
                Penjualan (Sales)
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                Pendapatan (Revenue)
            </div>
        </div>

        <div class="h-64 border border-gray-200 rounded-lg p-4 flex items-center justify-center bg-gray-50">
            <p class="text-gray-400">Area Grafik (Chart.js / ApexCharts)</p>
        </div>
        
        <div class="flex justify-between mt-4 text-xs text-gray-500 px-2">
            <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MAY</span><span>JUN</span><span>JUL</span><span>AUG</span><span>SEP</span><span>OCT</span><span>NOV</span><span>DEC</span>
        </div>
    </div>
</div>
  <div class="mt-8 pt-4 border-t border-gray-200">
            <h2 class="text-xl font-alata mb-3">Tambah Meja Baru</h2>
            <form action="{{ route('make.table') }}" method="POST" class="flex items-end gap-4">
                @csrf
                <div class="flex flex-col">
                    <label for="number_table" class="text-sm text-gray-600 mb-1">Nomor Meja</label>
                    <select name="number_table" id="number_table" class="h-10 border border-gray-300 rounded-lg p-2 focus:ring-primary focus:border-primary">
                        @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="bg-secondary text-background h-10 px-6 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300">
                    Tambah
                </button>
            </form>
        </div>
@endsection