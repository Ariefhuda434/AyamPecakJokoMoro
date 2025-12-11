@extends('layouts.app')

@section('title', 'Menu Meja ' . $No_Table)

@section('content')

{{-- Ambil Keranjang dari Session. Jika kosong, default ke array kosong. --}}
@php
    $cartItems = session('cart', []);
    $cartCount = array_sum(array_column($cartItems, 'Quantity'));
    $cartTotal = array_sum(array_map(function($item) {
        return $item['Price'] * $item['Quantity'];
    }, $cartItems));
    
    // Asumsi: Kita perlu tahu siapa employee_id (staf) yang mencatat order ini.
    // Jika sistem ini digunakan oleh staf yang login, gunakan auth()->user()->id.
    // Jika ini adalah tablet pelanggan, ID staf harus dipilih di checkout.
    $employeeId = 1; // Ganti dengan logika Anda untuk menentukan employee ID
@endphp
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div x-data="{ isCartOpen: false }" class="h-full min-h-screen max-w-full">
    
    {{-- BAR ATAS (HEADER) --}}
    <div class="h-18 w-full flex items-center justify-between px-3 py-2 border-b">
        <div class="flex items-center">
            <p class="text-primary font-alata text-xl md:text-2xl ml-2">Menu Meja {{ $No_Table }}</p>
        </div>
        
        {{-- Tombol Keranjang: Menampilkan item dari SESSION --}}
        <button @click="isCartOpen = true" class="flex items-center bg-white rounded-full border-2 border-primary p-2 shadow-md hover:bg-gray-50 transition">
            <span class="text-xs font-semibold text-primary mr-2 hidden sm:inline">
                {{ $cartCount }} Item
            </span>
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </button>
    </div>

    {{-- KATEGORI MENU (Tetap Sama) --}}
    <div class="w-full flex mt-4 justify-start px-3 gap-3 overflow-x-auto pb-4">
        {{-- ... (Kode Kategori) ... --}}
    </div> 
    
    <h3 class="text-xl font-alata mt-6 mb-4 px-3">Daftar Menu</h3>
    <hr class="mx-3 border-primary/50">

    {{-- DAFTAR MENU + FORM ADD TO CART --}}
    <div class="w-full flex flex-wrap justify-center md:justify-start lg:justify-center gap-4 py-6 pb-20 px-3">
        @forelse ($menus as $menu)
            <div class="h-auto w-40 sm:w-44 md:w-48 flex flex-col items-center bg-white border-4 rounded-[1rem] border-primary shadow-lg overflow-hidden transition-shadow hover:shadow-xl p-2 pb-4">
                {{-- Placeholder Gambar --}}
                <div class="h-28 w-11/12 bg-gray-300 mt-2 rounded-[0.5rem] flex items-center justify-center text-gray-500 text-sm">
                    
                </div>
                
                {{-- Detail Menu --}}
                <div class="w-11/12 h-10 flex justify-center text-center p-1">
                    <p class="font-semibold line-clamp-2 text-sm">{{ $menu->Name }}</p>
                </div>
                <div class="w-full h-10 flex justify-between px-4">
                    <p class="font-bold font-alata mt-2 text-lg text-primary">
                        RP{{ number_format($menu->Price, 0, ',', '.') }}
                    </p>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="w-full px-2">
                    @csrf
                    
                    <input type="hidden" name="Menu_id" value="{{ $menu->Menu_id }}">
                    
                    <div class="form-group mb-2">
                        <label for="Quantity-{{ $menu->Menu_id }}" class="text-xs font-medium block">Jumlah:</label>
                        <input 
                            type="number" 
                            name="Quantity" 
                            id="Quantity-{{ $menu->Menu_id }}" 
                            value="1" 
                            min="1" 
                            class="w-full border border-gray-300 rounded-lg text-center p-1 text-sm"
                            required
                        >
                    </div>

                    <div class="form-group mb-3">
                        <label for="Notes-{{ $menu->Menu_id }}" class="text-xs font-medium block">Catatan:</label>
                        <input 
                            type="text" 
                            name="Notes" 
                            id="Notes-{{ $menu->Menu_id }}" 
                            class="w-full border border-gray-300 rounded-lg p-1 text-sm"
                            placeholder="Pedas/Tanpa gula"
                        >
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-bold text-sm hover:bg-primary/80 transition">
                        Tambah ke Pesanan
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 mt-10">Tidak ada menu yang tersedia saat ini.</p>
        @endforelse
    </div>
    
    {{-- SIDEBAR KERANJANG (Diambil dari SESSION) --}}
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
                @if (count($cartItems) > 0)
                    @foreach ($cartItems as $itemId => $item)
                        <div class="flex items-start justify-between border-b pb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0"></div>
                                <div>
                                    <p class="font-semibold text-sm">{{ $item['Name'] }} (x{{ $item['Quantity'] }})</p>
                                    <p class="text-xs text-gray-500">Harga Satuan: RP{{ number_format($item['Price'], 0, ',', '.') }}</p>
                                    @if($item['Notes'])
                                        <p class="text-xs text-red-500 italic">Catatan: {{ $item['Notes'] }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="font-bold text-sm">
                                RP{{ number_format($item['Price'] * $item['Quantity'], 0, ',', '.') }}
                            </p>
                            cu
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center mt-10">Keranjang masih kosong.</p>
                @endif
            </div>
            {{-- @foreach ($customerId as $test )
                {{ $test['Name'] }}
            @endforeach --}}
            <div class="p-4 border-t shadow-lg">
                <div class="flex justify-between font-bold text-lg mb-3">
                    <span>Total Keseluruhan:</span>
                    <span>RP{{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                @if (count($cartItems) > 0)
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="No_Table" value="{{ $No_Table }}">
                        <input type="hidden" name="Employee_id" value="{{ $employeeId }}"> 
                        
                        <input type="hidden" name="Customer_id" value="{{ $customerId }}">
                        <input type="hidden" name="Total" value="{{ $cartTotal }}">
                        
                        <p class="text-sm text-gray-600 mb-2">Meja: <strong>{{ $No_Table }}</strong> | Staf ID: <strong>{{ $employeeId }}</strong>Customer ID: <strong>{{ $customerId ?? 'Tamu' }}</strong></p>
                        
                        <button type="submit" class="w-full block text-center bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition font-bold">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                @endif
            </div>
            
        </div>
    </div>

</div>

@endsection