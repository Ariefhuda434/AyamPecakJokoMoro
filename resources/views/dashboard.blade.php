@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex h-screen w-screen bg-[#F9F5EB] overflow-hidden" x-data="{ showRecipeModal: false, showSalesModal: false }">
    {{-- Sidebar --}}
    <aside class="w-24 lg:w-64 h-full bg-primary flex flex-col justify-between py-6 fixed left-0 top-0 z-20 transition-all duration-300">
        <div>
            <div class="flex flex-col items-center mb-10 px-4">
                <div class="w-20 h-20 lg:w-32 lg:h-32 flex items-center justify-center mb-4">
                    {{-- Logo Placeholder --}}
                    <div class="text-white text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.046 8.25 8.25 0 0 1 11.824 2.68M10 5.25h4m-4 3h4m-4 3h4m-4 3h4" />
                        </svg>
                        <span class="font-bold text-xs uppercase tracking-widest">Ayam Pecak<br>Joko Moro</span>
                    </div>
                </div>
            </div>

            <nav class="space-y-6 px-4">
                <a href="/dashboard" class="flex flex-col items-center text-secondary transition group">
                    <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center mb-1 text-primary shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-alata hidden lg:block font-bold">Dashboard</span>
                </a>
                
                <a href="/order/menu" class="flex flex-col items-center text-white hover:text-secondary transition group">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center mb-1 text-white group-hover:bg-secondary group-hover:text-primary transition">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-alata hidden lg:block">Menu</span>
                </a>

                <a href="/transactions" class="flex flex-col items-center text-white hover:text-secondary transition group">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center mb-1 text-white group-hover:bg-secondary group-hover:text-primary transition">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-alata hidden lg:block">Transaction</span>
                </a>

                <a href="/stock" class="flex flex-col items-center text-white hover:text-secondary transition group">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center mb-1 text-white group-hover:bg-secondary group-hover:text-primary transition">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-alata hidden lg:block">Database</span>
                </a>

                <a href="/karyawan" class="flex flex-col items-center text-white hover:text-secondary transition group">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center mb-1 text-white group-hover:bg-secondary group-hover:text-primary transition">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-alata hidden lg:block">Waiter</span>
                </a>
            </nav>
        </div>
        <button class="flex flex-col items-center text-white hover:text-secondary transition">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 2.062-5M12 12h9" />
            </svg>
            <span class="text-xs font-alata hidden lg:block">Logout</span>
        </button>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 ml-24 lg:ml-64 p-8 overflow-y-auto h-full">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white hover:bg-opacity-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <h2 class="text-3xl font-bold text-primary font-alata">Dashboard</h2>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-primary">
                        <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                    </svg>
                    <span class="absolute top-0 right-1 w-2.5 h-2.5 bg-secondary rounded-full border border-[#F9F5EB]"></span>
                </button>
                <div class="h-8 w-[1px] bg-primary mx-2"></div>
                <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden border-2 border-primary">
                    <img src="https://i.pravatar.cc/150?img=3" alt="User" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        {{-- Top Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Card 1 --}}
            <div @click="showSalesModal = true" class="bg-primary p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300 cursor-pointer">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Rekap Penjualan</p>
                        <h3 class="text-2xl font-bold">Rp 9.000.000,00</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-primary font-bold">
                        $
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <p class="text-xs text-gray-400">25 November 2025</p>
                    <div class="flex gap-1 items-end h-8">
                        @for($i=0; $i<10; $i++)
                            <div class="w-1.5 bg-[#4ADE80] rounded-t-sm" style="height: {{ rand(40, 100) }}%"></div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-primary p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Pendapatan Bulanan</p>
                        <h3 class="text-2xl font-bold">Rp 125.752.350,00</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-primary font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                          <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                          <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <p class="text-xs text-gray-400">1 Nov - 1 Des</p>
                    <div class="flex gap-1 items-end h-8">
                        @for($i=0; $i<10; $i++)
                            <div class="w-1.5 bg-[#A7F3D0] rounded-t-sm" style="height: {{ rand(40, 100) }}%"></div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="bg-primary p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Meja Terpakai</p>
                        <h3 class="text-2xl font-bold">25 Meja</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-primary font-bold">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <p class="text-xs text-gray-400 invisible">Placeholder</p>
                    <div class="flex gap-1 items-end h-8">
                        @for($i=0; $i<10; $i++)
                            <div class="w-1.5 bg-[#4ADE80] rounded-t-sm" style="height: {{ rand(40, 100) }}%"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Middle Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Hidangan Populer --}}
            <div class="bg-primary p-6 rounded-2xl shadow-lg text-white">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Hidangan Populer</h3>
                    <button class="text-secondary text-sm hover:underline">Lihat Semua</button>
                </div>
                <div class="space-y-4">
                    @for($i=0; $i<4; $i++)
                    <div class="flex items-center bg-[#4A302C] p-3 rounded-xl">
                        <img src="https://via.placeholder.com/60" class="w-14 h-14 rounded-lg object-cover mr-4" alt="Food">
                        <div class="flex-1">
                            <h4 class="font-bold">Ayam Goreng Pecak</h4>
                            <p class="text-xs text-gray-400">Porsi : 01 orang</p>
                        </div>
                        <div class="text-right">
                            <span class="text-secondary text-xs font-bold">Tersedia</span>
                            <p class="font-bold">Rp 15.000</p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            {{-- Menu -> Resep --}}
            <div class="bg-primary p-6 rounded-2xl shadow-lg text-white">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Menu &rarr; Resep</h3>
                    <button class="text-secondary text-sm hover:underline">Selengkapnya</button>
                </div>
                <div class="space-y-4">
                    @for($i=0; $i<4; $i++)
                    <div class="flex items-center bg-[#4A302C] p-3 rounded-xl">
                        <img src="https://via.placeholder.com/60" class="w-14 h-14 rounded-lg object-cover mr-4" alt="Food">
                        <div class="flex-1">
                            <h4 class="font-bold">Ayam Goreng Pecak</h4>
                            <p class="font-bold text-sm">Rp 15.000 <span class="text-secondary text-xs ml-2">Tersedia</span></p>
                        </div>
                        <div class="flex gap-2">
                            <button @click="showRecipeModal = true" class="p-2 hover:bg-white/10 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </button>
                            <button class="p-2 hover:bg-red-500/20 text-red-500 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Bottom Section (Ringkasan) --}}
        <div class="bg-primary p-6 rounded-2xl shadow-lg text-white">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h3 class="text-xl font-bold">Ringkasan</h3>
                <div class="flex items-center gap-4">
                    <div class="bg-[#4A302C] rounded-lg p-1 flex">
                        <button class="px-4 py-1.5 rounded-md bg-secondary text-primary font-bold text-sm">Bulanan</button>
                        <button class="px-4 py-1.5 rounded-md text-gray-300 hover:text-white text-sm">Harian</button>
                        <button class="px-4 py-1.5 rounded-md text-gray-300 hover:text-white text-sm">Mingguan</button>
                    </div>
                    <button class="flex items-center gap-2 bg-[#4A302C] px-4 py-2 rounded-lg text-secondary text-sm font-bold border border-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>
            
            <div class="flex gap-6 mb-6">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-secondary"></div>
                    <span class="text-sm">Penjualan</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                    <span class="text-sm">Pendapatan</span>
                </div>
            </div>

            {{-- Chart Placeholder --}}
            <div class="relative h-64 w-full bg-[#4A302C] rounded-xl flex items-end justify-between px-4 pb-4 pt-10">
                {{-- Fake Chart Lines (SVG) --}}
                <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 100 50" preserveAspectRatio="none">
                    {{-- Line 1 --}}
                    <path d="M0,40 Q10,35 20,42 T40,30 T60,20 T80,35 T100,10" fill="none" stroke="#D4AF37" stroke-width="0.5" />
                    {{-- Line 2 --}}
                    <path d="M0,45 Q10,48 20,40 T40,38 T60,30 T80,40 T100,25" fill="none" stroke="#D1D5DB" stroke-width="0.5" />
                </svg>
                
                {{-- X Axis Labels --}}
                <div class="absolute bottom-2 left-0 right-0 flex justify-between px-6 text-[10px] text-gray-400 uppercase">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                </div>
                 {{-- Y Axis Labels --}}
                <div class="absolute top-0 right-2 bottom-8 flex flex-col justify-between text-[10px] text-gray-400 py-2">
                    <span>5k</span><span>4k</span><span>3k</span><span>2k</span><span>1k</span><span>0</span>
                </div>
            </div>
        </div>
    </main>

    {{-- Recipe Modal --}}
    <div x-show="showRecipeModal" class="fixed inset-0 z-50 flex justify-end" style="display: none;">
        <div @click="showRecipeModal = false" class="absolute inset-0 bg-black/50 transition-opacity" x-transition.opacity></div>
        
        <div class="relative w-full max-w-md bg-[#F9F5EB] h-full shadow-2xl p-8 flex flex-col border-l-4 border-primary rounded-l-[3rem]" 
             x-transition:enter="transform transition ease-in-out duration-300" 
             x-transition:enter-start="translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transform transition ease-in-out duration-300" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="translate-x-full">
            
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-primary font-neue tracking-wide uppercase">Resep Masakan</h2>
                <button @click="showRecipeModal = false" class="bg-primary text-white rounded-full p-1 hover:bg-opacity-80">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-6 overflow-y-auto">
                {{-- Image Upload Placeholder --}}
                <div class="flex flex-col items-center mb-6">
                    <div class="w-48 h-48 bg-secondary rounded-xl flex flex-col items-center justify-center text-primary mb-2 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2 opacity-50">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <span class="text-xs font-bold opacity-70">Select icon here</span>
                    </div>
                    <button class="text-primary text-sm font-bold underline">Change Icon</button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" value="Ayam bakar" class="w-full bg-transparent border-2 border-primary rounded-lg px-4 py-3 text-primary font-bold focus:outline-none focus:ring-2 focus:ring-secondary">
                    <input type="text" value="100.000" class="w-full bg-transparent border-2 border-primary rounded-lg px-4 py-3 text-primary font-bold focus:outline-none focus:ring-2 focus:ring-secondary">
                </div>

                <div>
                    <h4 class="text-primary font-bold mb-2">Bahan-Bahan</h4>
                    <div class="grid grid-cols-3 gap-4 mb-2">
                        <input type="text" value="Ayam" class="col-span-2 w-full bg-transparent border-2 border-primary rounded-lg px-4 py-3 text-primary font-bold focus:outline-none focus:ring-2 focus:ring-secondary">
                        <input type="text" value="1" class="w-full bg-transparent border-2 border-primary rounded-lg px-4 py-3 text-primary font-bold focus:outline-none focus:ring-2 focus:ring-secondary text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sales Modal --}}
    <div x-show="showSalesModal" class="fixed inset-0 z-50 flex justify-end" style="display: none;">
        <div @click="showSalesModal = false" class="absolute inset-0 bg-black/50 transition-opacity" x-transition.opacity></div>
        
        <div class="relative w-full max-w-4xl bg-primary h-full shadow-2xl p-8 flex flex-col border-l-4 border-secondary rounded-l-[3rem]" 
             x-transition:enter="transform transition ease-in-out duration-300" 
             x-transition:enter-start="translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transform transition ease-in-out duration-300" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="translate-x-full">
            
            <div class="flex items-center justify-between mb-8 text-white">
                <div class="flex items-center gap-4">
                    <button @click="showSalesModal = false" class="bg-[#4A302C] p-2 rounded-full hover:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold">Rekap Penjualan</h2>
                </div>
                <div class="flex items-center gap-4">
                     <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-secondary">
                            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gray-300 overflow-hidden border border-secondary">
                        <img src="https://i.pravatar.cc/150?img=3" alt="User" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="bg-[#4A302C] rounded-2xl p-6 flex-1 overflow-y-auto">
                <div class="flex justify-between items-center mb-6 text-white">
                    <h3 class="text-xl font-bold">Total Penjualan (20)</h3>
                    <button class="text-secondary text-sm hover:underline">Lihat Semua</button>
                </div>

                <div class="space-y-4">
                    {{-- Order Item Placeholder --}}
                    <div class="bg-[#5C403C] p-4 rounded-xl border-l-4 border-secondary">
                        <h4 class="text-white font-bold text-lg">Order 12</h4>
                        <div class="mt-2 text-gray-300 text-sm">
                            <p>Items: Ayam Goreng Pecak (2), Es Teh (2)</p>
                            <p class="mt-1 font-bold text-secondary">Total: Rp 40.000</p>
                        </div>
                    </div>
                     <div class="bg-[#5C403C] p-4 rounded-xl border-l-4 border-transparent hover:border-secondary transition">
                        <h4 class="text-white font-bold text-lg">Order 11</h4>
                        <div class="mt-2 text-gray-300 text-sm">
                            <p>Items: Nasi Goreng (1)</p>
                            <p class="mt-1 font-bold text-secondary">Total: Rp 15.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection