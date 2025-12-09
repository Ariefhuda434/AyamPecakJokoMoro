@extends('layouts.app')

@section('title', 'Menu Meja ' . $No_Table)

@section('content')

{{-- Tambahkan isCartOpen untuk mengontrol sidebar keranjang --}}
<div x-data="{ isCartOpen: false }" class="h-full min-h-screen max-w-full">
    
    <div class="h-18 w-full flex items-center justify-between px-3 py-2 border-b">
        <div class="flex items-center">
            <p class="text-primary font-alata text-xl md:text-2xl ml-2">Menu Meja {{ $No_Table }}</p>
        </div>
        
        {{-- Tombol Keranjang: Ubah menjadi @click="isCartOpen = true" --}}
        <button @click="isCartOpen = true" class="flex items-center bg-white rounded-full border-2 border-primary p-2 shadow-md hover:bg-gray-50 transition">
            <span class="text-xs font-semibold text-primary mr-2 hidden sm:inline">
                {{ $activeOrder ? $activeOrder->orderItems->sum('quantity') : 0 }} Item
            </span>
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </button>
    </div>

    
    <div class="w-full flex mt-4 justify-start px-3 gap-3 overflow-x-auto pb-4">
        <a href="{{ route('order.index', ['table' => $No_Table, 'category' => 'Semua']) }}" class="flex-shrink-0 w-32 md:w-40 h-32 bg-secondary rounded-[1rem] p-3 transition-colors text-center shadow-sm">
            <div class="h-10 w-10 bg-primary mx-auto mt-2 rounded-full"></div>
            <p class="text-black font-alata text-lg mt-1">Semua</p>
            <p class="text-primary font-alata text-sm">{{ $menus->count() }} item</p>
        </a>
        <a href="{{ route('order.index', ['table' => $No_Table, 'category' => 'Makanan']) }}" class="flex-shrink-0 w-32 md:w-40 h-32 bg-primary rounded-[1rem] p-3 transition-colors text-center shadow-md">
            <div class="h-10 w-10 bg-background mx-auto mt-2 rounded-full"></div>
            <p class="text-background font-alata text-lg mt-1">Makanan</p>
            <p class="text-background font-alata text-sm">{{ $menus->where('Category', 'Makanan')->count() }} item</p>
        </a>
        <a href="{{ route('order.index', ['table' => $No_Table, 'category' => 'Minuman']) }}" class="flex-shrink-0 w-32 md:w-40 h-32 bg-primary rounded-[1rem] p-3 transition-colors text-center shadow-md">
            <div class="h-10 w-10 bg-background mx-auto mt-2 rounded-full"></div>
            <p class="text-background font-alata text-lg mt-1">Minuman</p>
            <p class="text-background font-alata text-sm">{{ $menus->where('Category', 'Minuman')->count() }} item</p>
        </a>
    </div> 
    
    <h3 class="text-xl font-alata mt-6 mb-4 px-3">Daftar Menu</h3>
    <hr class="mx-3 border-primary/50">

    <div class="w-full flex flex-wrap justify-center md:justify-start lg:justify-center gap-4 py-6 pb-20 px-3">
        @forelse ($menus as $menu)
            <div class="h-72 w-40 sm:w-44 md:w-48 flex flex-col items-center bg-white border-4 rounded-[1rem] border-primary shadow-lg overflow-hidden transition-shadow hover:shadow-xl">
                <div class="h-28 w-11/12 bg-gray-300 mt-4 rounded-[0.5rem] flex items-center justify-center text-gray-500 text-sm">
                    

[Image of {{ $menu->Name }}]

                </div>
                <div class="w-11/12 h-10 flex justify-center text-center p-1">
                    <p class="font-semibold line-clamp-2 text-sm">{{ $menu->Name }}</p>
                </div>
                <div class="w-full h-10 flex justify-between px-4">
                    <p class="font-bold font-alata mt-2 text-lg text-primary">
                        RP{{ number_format($menu->Price, 0, ',', '.') }}
                    </p>
                </div>
                <form action="{{ route('add.to.cart', $No_Table) }}" method="POST" class="w-full flex items-center flex-col justify-center mt-auto mb-4">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <button type="submit" 
                            class="bg-primary text-background h-10 w-4/5 rounded-[0.5rem] text-sm hover:bg-red-700 transition duration-200 shadow-md">
                        Tambahkan
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 mt-10">Tidak ada menu yang tersedia saat ini.</p>
        @endforelse
    </div>

    <div x-cloak x-show="isCartOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50"
         @click.away="isCartOpen = false"> 

        <div @click.stop
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 w-full md:w-96 h-full bg-white shadow-2xl flex flex-col">
            
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="text-2xl font-alata text-primary">Pesanan Meja {{ $No_Table }}</h3>
                <button @click="isCartOpen = false" class="text-gray-600 hover:text-red-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-grow p-4 overflow-y-auto space-y-4">
                @if ($activeOrder && $activeOrder->orderItems->count() > 0)
                    @foreach ($activeOrder->orderItems as $item)
                        <div class="flex items-center justify-between border-b pb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0"></div>
                                <div>
                                    <p class="font-semibold text-sm">{{ $item->menu->Name }}</p>
                                    <p class="text-xs text-gray-500">RP{{ number_format($item->menu->Price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                {{-- <form action="{{ route('order.update.item', $item->id) }}" method="POST" class="flex items-center space-x-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="decrement" class="w-6 h-6 bg-gray-200 rounded-full hover:bg-gray-300 flex items-center justify-center text-sm" @click.stop>
                                        -
                                    </button>

                                    <span class="font-bold w-4 text-center">{{ $item->quantity }}</span>
                                    
                                    <button type="submit" name="action" value="increment" class="w-6 h-6 bg-primary text-white rounded-full hover:bg-red-700 flex items-center justify-center text-sm" @click.stop>
                                        +
                                    </button>
                                </form>
                                
                                <form action="{{ route('remove.item.cart', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" @click.stop>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form> --}}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center mt-10">Keranjang masih kosong.</p>
                @endif
            </div>

            <div class="p-4 border-t shadow-lg">
                <div class="flex justify-between font-bold text-lg mb-3">
                    <span>Total:</span>
                    <span>RP{{ number_format($activeOrder ? $activeOrder->total_price : 0, 0, ',', '.') }}</span>
                </div>
{{--                 
                <a href="{{ route('order.checkout', $No_Table) }}" class="w-full block text-center bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition font-bold">
                    Konfirmasi Pesanan
                </a> --}}
            </div>
            
        </div>
    </div>

</div>

@endsection