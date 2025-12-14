@extends('layouts.app')

@section('title', 'Menu Meja ' . $No_Table)

@section('content')

@php
    $cartItems = session('cart', []);
    $cartCount = array_sum(array_column($cartItems, 'Quantity'));
    $cartTotal = array_sum(array_map(function($item) {
        return $item['Price'] * $item['Quantity'];
    }, $cartItems));
    
    $employeeId = 1; 
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
       <a href="{{ route('customer.index') }}" class="mr-3 text-primary hover:text-secondary transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
        </a>    
    <div class="h-18 w-full flex items-center justify-between px-3 py-2 border-b">
        <div class="flex items-center">
            <p class="text-primary font-alata text-xl md:text-2xl ml-2">Menu Tersedia</p>
        </div>
        <button @click="isCartOpen = true" class="flex items-center bg-white  rounded-full border-2 border-primary p-2 shadow-md hover:scale-102 transition">
            <span class="text-xs font-semibold text-primary mr-2 hidden sm:inline">
                {{ $cartCount }} Item
            </span>
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </button>
    </div>

    <div class="w-full flex mt-4 justify-start px-3 gap-3 overflow-x-auto pb-4">
         <div class="flex gap-5">
        <a href="{{ route('order.index', ['table' => $No_Table, 'customer' => $Customer_id]) }} class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <img src="{{ asset('images/makanan.png') }}" alt="Home Icon" class="h-15 w-15  mr-3 rounded-md">
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Semua</p>
                    <p class="font-alata text-lg font-bold">{{ $totalmenu }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('order.index', ['table' => $No_Table, 'customer' => $Customer_id, 'Category' => 'Makanan']) }}" class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <img src="{{ asset('images/rice.png') }}" alt="Home Icon" class="h-15 w-14  mr-3 rounded-md">
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Makanan</p>
                    <p class="font-alata text-lg font-bold">{{ $MenuMakanan }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('order.index', ['table' => $No_Table, 'customer' => $Customer_id, 'Category' => 'Makanan']) }} class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <img src="{{ asset('images/minuman.png') }}" alt="Home Icon" class="h-15 w-15  mr-3 rounded-md">
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Minuman</p>
                    <p class="font-alata text-lg font-bold">{{ $MenuMinuman }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('order.index',['table' => $No_Table, 'customer' => $Customer_id, 'Category' => 'Cemilan']) }}" class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <img src="{{ asset('images/snack.png') }}" alt="Home Icon" class="h-15 w-15  mr-3 rounded-md">
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Cemilan</p>
                    <p class="font-alata text-lg font-bold">{{ $MenuCemilan }}</p>
                </div>
            </div>
        </a>

        </div>
    </div> 
    
    <h3 class="text-xl font-alata mt-6 mb-4 px-3">Daftar Menu</h3>
    <hr class="mx-3 border-primary/50">

   <div class="w-full flex flex-wrap justify-center md:justify-start lg:justify-center gap-6 py-6 pb-20 px-3">
    @forelse ($menus as $menu)
    <div class="
        h-auto w-56 sm:w-64 flex flex-col items-center bg-white 
        border border-gray-200 rounded-xl shadow-lg 
        transform transition duration-300 hover:scale-[1.02] hover:shadow-xl
        p-3 
    ">
        <div class="h-36 w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-sm overflow-hidden">
             <p>Foto Menu </p> 
        </div>
        
        <div class="w-full pt-3 pb-1">
            <p class="font-semibold line-clamp-2 text-lg text-gray-800 h-14">
                {{ $menu->Name }}
            </p>
            
            <div class="flex justify-between items-center  mb-3">
                <p class="font-extrabold font-alata text-2xl text-primary">
                    Rp {{ number_format($menu->Price ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <form action="{{ route('cart.add') }}" method="POST" class="w-full">
            @csrf
            
            <input type="hidden" name="Menu_id" value="{{ $menu->Menu_id }}">
            
            <div class="flex items-end space-x-2 mb-2">
                <div class="flex-grow-0">
                    <label for="Quantity-{{ $menu->Menu_id }}" class="text-xs font-medium block mb-1">Jumlah:</label>
                    <input 
                        type="text" 
                        name="Quantity" 
                        id="Quantity-{{ $menu->Menu_id }}" 
                        value="1" 
                        min="1" 
                        class="w-10 border border-gray-300 rounded-lg text-center p-2 text-sm focus:border-primary focus:ring-primary"
                        required
                    >
                </div>
                
                <div class="flex-grow">
                    <label for="Notes-{{ $menu->Menu_id }}" class="text-xs font-medium block mb-1">Catatan:</label>
                    <input 
                        type="text" 
                        name="Notes" 
                        id="Notes-{{ $menu->Menu_id }}" 
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:border-primary focus:ring-primary"
                        placeholder=""
                    >
                </div>
            </div>
            
            <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-semibold text-base hover:bg-primary/90 transition shadow-md mt-2 flex justify-center items-center space-x-2">
                <span>Tambah ke Pesanan</span>
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
             class="fixed top-0 right-0 w-full md:w-110 h-full bg-white shadow-2xl rounded-l-[5rem] border-l-10 border-t-10 border-b-10 border-primary flex flex-col">
            
            <div class="p-4  flex justify-between items-center mt-8 rounded-t-[5rem] bg-gray-50">
                <h3 class="text-3xl font-neue text-primary">Pesanan Meja {{ $No_Table }}</h3>
                <button @click="isCartOpen = false" class=" bg-primary rounded-full p-1 hover:bg-red-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-grow p-4 overflow-y-auto space-y-4">
                @if (count($cartItems) > 0)
                    @foreach ($cartItems as $itemId => $item)
<div class="flex mb-4">
    
<div class="flex items-start border-4 border-primary rounded-l-lg p-3 flex-grow">
    <div class="flex items-center space-x-4 w-full">
        
        <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0">
        </div>
        
        <div class="flex-grow min-w-0"> 
            
            <p class="font-semibold text-xl text-gray-800 break-words">{{ $item['Name'] }}</p>

            <p class="text-xs text-gray-500 mt-1 whitespace-nowrap">
                Satuan: Rp{{ number_format($item['Price'], 0, ',', '.') }}
            </p>
            
            @if($item['Notes'])
                <p class="text-xs text-red-500 italic mt-1 break-words">Catatan: {{ $item['Notes'] }}</p>
            @endif
            
        </div>

        <div class="flex-shrink-0 text-right ml-4">
            <p class="font-bold text-xl text-primary whitespace-nowrap">
                Rp{{ number_format($item['Price'] * $item['Quantity'], 0, ',', '.') }}
            </p>
            <p class="font-bold text-lg text-gray-600 mt-1 whitespace-nowrap">
                (x{{ $item['Quantity'] }})
            </p>
        </div>
        
    </div>
</div>
<form action="{{ route('cart.destroy', ['menu' => $item['Menu_id']]) }}" method="POST">
    @csrf
    @method('DELETE')
    
    <button type="submit" 
            class="
                w-8 h-full flex items-center justify-center 
                bg-secondary border-t-4 border-b-4 border-r-4 border-primary 
                rounded-r-lg flex-shrink-0 
                hover:bg-accent transition duration-200
            "
            onclick="return confirm('Yakin hapus item ini?')"
            title="Hapus Item">
    </button>
</form>
    
</div>

                    @endforeach
                @else
                    <p class="text-gray-500 text-center mt-10">Keranjang masih kosong.</p>
                @endif
            </div>
            {{-- @foreach ($customerId as $test )
                {{ $test['Name'] }}
            @endforeach --}}
          <div class="p-4 mb-5 rounded-b-[5rem] border-t bg-white sticky bottom-0 z-10">
    
    <div class="flex justify-between font-alata font-bold text-xl mb-4 text-gray-800">
        <span>Total Keseluruhan:</span>
        <span class="text-primary-dark">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
    </div>
    
    @if (count($cartItems) > 0)
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            
            <input type="hidden" name="Employee_id" value="{{ $employeeId }}"> 
            <input type="hidden" name="Customer_id" value="{{ $Customer_id}}">
            <input type="hidden" name="Total" value="{{ $cartTotal }}">
            
            <div class="text-xs text-gray-500 flex mb-3 border-t pt-2 ">
                <p>Meja:  <strong>{{ $No_Table }} </strong></p> | 
                <p> Staf ID:  <strong>{{ $employeeId }} </strong></p> | 
                <p> Customer ID:  <strong>{{ $Customer_id ?? 'Tamu' }} </strong></p>
            </div>
            <button type="submit" 
                class="w-full block text-center bg-primary text-white py-3 rounded-lg hover:bg-red-900 transition font-alata font-bold text-lg shadow-md">
                Konfirmasi Pesanan
            </button>
        </form>
    @else
        <button type="button" disabled
            class="w-full block text-center bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed font-alata font-bold text-lg">
            Keranjang Kosong
        </button>
    @endif
</div>
            
        </div>
    </div>

</div>

@endsection