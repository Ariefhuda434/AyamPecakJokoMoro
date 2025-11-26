@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="h-screen w-screen bg-background flex flex-col font-alata overflow-hidden">
    {{-- Header --}}
    <div class="px-6 py-6 flex items-center justify-between bg-background z-10">
        <a href="/dashboard" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:opacity-90 transition shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-primary font-neue tracking-wide">Transaksi</h1>
        <div class="flex items-center gap-5">
            <button class="relative text-primary hover:text-secondary transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>
                <span class="absolute top-0 right-0 w-3 h-3 bg-secondary rounded-full border-2 border-background flex items-center justify-center text-[8px] font-bold"></span>
            </button>
            <div class="h-8 w-[2px] bg-primary/20"></div>
            <div class="w-12 h-12 rounded-full bg-gray-300 overflow-hidden border-2 border-primary shadow-md">
                <img src="https://i.pravatar.cc/150?img=11" alt="User" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    {{-- Main Content Container (Dark Background) --}}
    <div class="flex-1 bg-primary relative flex flex-col pt-2 pl-2 overflow-hidden">
        {{-- Light Card (Rounded Top-Left) --}}
        <div class="flex-1 bg-background rounded-tl-[4rem] flex flex-col overflow-hidden relative shadow-[0_-10px_40px_rgba(0,0,0,0.2)]">
            
            {{-- Handle --}}
            <div class="w-24 h-1.5 bg-primary/80 rounded-full mx-auto mt-4 mb-2"></div>

            {{-- Order Info --}}
            <div class="px-8 py-4 flex justify-between items-center text-primary font-bold text-xl font-neue">
                <span>Items(8)</span>
                <span class="font-alata text-lg">Budi Mantap | Meja 2</span>
            </div>

            {{-- Toggle Tabs --}}
            <div class="px-8 mb-6">
                <div class="flex rounded-2xl overflow-hidden shadow-lg">
                    <button class="flex-1 py-4 bg-secondary text-primary font-bold text-lg font-alata hover:bg-opacity-90 transition">Dine in</button>
                    <button class="flex-1 py-4 bg-primary text-white font-bold text-lg font-alata hover:bg-opacity-90 transition">Take Away</button>
                </div>
            </div>

            {{-- Scrollable List --}}
            <div class="flex-1 overflow-y-auto px-8 space-y-5 pb-6">
                @for ($i = 0; $i < 3; $i++)
                <div class="bg-background border-[3px] border-primary rounded-2xl p-3 flex items-center relative overflow-hidden shadow-md group hover:scale-[1.01] transition-transform duration-200">
                    <div class="w-20 h-24 bg-gray-100 rounded-xl mr-4 overflow-hidden flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=150&auto=format&fit=crop" alt="Teh Manis" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 pr-10">
                        <h3 class="text-primary font-bold text-lg leading-tight mb-2 font-alata">Teh Manis Top Markocop Tanpa Gula</h3>
                        <p class="text-primary font-bold text-sm opacity-80">RP20.000</p>
                    </div>
                    <div class="text-primary font-bold text-2xl font-neue mr-6">2x</div>
                    {{-- Decorative Strip --}}
                    <div class="absolute right-0 top-0 bottom-0 w-8 bg-secondary rounded-l-2xl transform translate-x-2"></div>
                </div>
                @endfor
            </div>

            {{-- Summary Section --}}
            <div class="px-8 pb-6">
                <div class="bg-[#D9D9D9] rounded-3xl p-6 text-primary font-bold font-alata shadow-inner">
                    <div class="flex justify-between mb-2 text-lg">
                        <span class="opacity-80">Sub Total</span>
                        <span>RP180.000</span>
                    </div>
                    <div class="flex justify-between mb-4 text-lg">
                        <span class="opacity-80">PPN 10%</span>
                        <span>RP18.000</span>
                    </div>
                    <div class="border-t-2 border-dashed border-primary/40 my-3"></div>
                    <div class="flex justify-between text-2xl font-neue mt-2">
                        <span>Total</span>
                        <span>RP198.000</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="bg-primary px-6 py-6 pb-8">
            <div class="flex gap-4">
                {{-- Tunai (Active) --}}
                <button class="flex-1 bg-secondary text-primary rounded-2xl py-4 flex flex-col items-center justify-center gap-1 shadow-lg transform hover:scale-105 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                    <span class="font-bold font-alata">Tunai</span>
                </button>

                {{-- Transfer --}}
                <button class="flex-1 bg-transparent border-2 border-white/20 text-white rounded-2xl py-4 flex flex-col items-center justify-center gap-1 hover:bg-white/10 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    <span class="font-bold font-alata">Transfer</span>
                </button>

                {{-- Qris --}}
                <button class="flex-1 bg-transparent border-2 border-white/20 text-white rounded-2xl py-4 flex flex-col items-center justify-center gap-1 hover:bg-white/10 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                    </svg>
                    <span class="font-bold font-alata">Qris</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection