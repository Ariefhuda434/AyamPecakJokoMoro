@extends('layouts.app')

@section('title', 'Pemesanan')

@section('content')

    <div class="min-h-screen w-full px-4 pt-4 pb-10">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 mb-8">
            
            <a href="{{ route('customer.index') }}" class="block">
                @php
                    $status_filter = request()->get('status_table', 'Semua');
                    $activeClass = $status_filter === 'Semua' ? 'bg-primary text-white shadow-xl scale-[1.02]' : 'bg-secondary text-primary';
                    $hoverClass = $status_filter !== 'Semua' ? 'hover:bg-primary hover:text-white' : '';
                @endphp
                <div class="flex p-4 w-full h-23 rounded-2xl shadow-md transition-all duration-400 ease-in-out {{ $activeClass }} {{ $hoverClass }}">
                    <img src="{{ asset('images/all.png') }}" alt="Semua Meja Icon" class="h-15 w-15 mr-3 rounded-md">
                    <div class="flex flex-col justify-center">
                        <p class="font-alata text-lg">Semua Meja</p>
                        <p class="font-alata text-lg font-bold">{{ $totalTables }}</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('customer.index',['status_table' => 'Kosong']) }}" class="block">
                @php
                    $activeClass = $status_filter === 'Kosong' ? 'bg-primary text-white shadow-xl scale-[1.02]' : 'bg-secondary text-primary';
                    $hoverClass = $status_filter !== 'Kosong' ? 'hover:bg-primary hover:text-white' : '';
                @endphp
                <div class="flex p-4 w-full h-23 rounded-2xl shadow-md transition-all duration-400 ease-in-out {{ $activeClass }} {{ $hoverClass }}">
                    <img src="{{ asset('images/kosong.png') }}" alt="Meja Kosong Icon" class="h-15 w-14 mr-3 rounded-md">
                    <div class="flex flex-col justify-center">
                        <p class="font-alata text-lg">Meja Kosong</p>
                        <p class="font-alata text-lg font-bold">{{ $availableTables }}</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('customer.index',['status_table' => 'Terisi']) }}" class="block">
                @php
                    $activeClass = $status_filter === 'Terisi' ? 'bg-primary text-white shadow-xl scale-[1.02]' : 'bg-secondary text-primary';
                    $hoverClass = $status_filter !== 'Terisi' ? 'hover:bg-primary hover:text-white' : '';
                @endphp
                <div class="flex p-4 w-full h-23 rounded-2xl shadow-md transition-all duration-400 ease-in-out {{ $activeClass }} {{ $hoverClass }}">
                    <img src="{{ asset('images/berisi.png') }}" alt="Meja Terisi Icon" class="h-15 w-14 mr-3 rounded-md">
                    <div class="flex flex-col justify-center">
                        <p class="font-alata text-lg">Meja Terisi</p>
                        <p class="font-alata text-lg font-bold">{{ $occupiedTables }}</p>
                    </div>
                </div>
            </a>

        </div>

        <div class="w-full border-t-1 pt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-4 justify-items-center">
            @foreach ($tables as $table) 
                
                @if ($table->status_table == 'Kosong')
                    <div class="w-full p-4 bg-white border-4 border-gray-300 rounded-2xl shadow-lg max-w-sm hover:shadow-xl transition duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <p class="font-alata text-gray-500 text-xl">Meja {{ $table ->No_Table }}</p>
                            <p class="text-xs font-semibold px-3 py-1 bg-red-100 text-primary rounded-full">{{ $table ->status_table }}</p>
                        </div>
                        
                        <form action="{{ route('make.customer') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="Name" placeholder="Nama" value="{{ old('Name') }}"
                                    class="w-full h-11 border-4 border-gray-300 rounded-xl rounded-bl-3xl 
                                        px-4 outline-none transition-all focus:border-secondary duration-300 ease-in-out
                                        placeholder-gray-500 font-sans text-base" />
                                <input type="hidden" name="No_Table" value="{{ $table->No_Table}}" />
                            </div>
                            
                            <div class="mb-4">
                                <input type="text" name="Phone_Number" placeholder="Nomor HP" value="{{ old('Phone_Number') }}"
                                    class="w-full h-11 border-4 border-gray-300 rounded-xl rounded-bl-3xl 
                                        px-4 outline-none transition-all focus:border-secondary duration-300 ease-in-out
                                        placeholder-gray-500 font-sans text-base" />
                            </div>
                            <div class="flex flex-col items-center">
                                <button type="submit" class="bg-gray-400 hover:bg-gray-600 transtion-all duration-600 text-background h-10 w-full rounded-lg text-sm font-semibold mb-1">
                                    Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                
                @else
                    @php
                        $currentCustomer = $table->activeCustomer ?? null; 
                        $customerId = $currentCustomer->Customer_id ?? null;
                    @endphp
                    
                    <div class="w-full p-4 border-4 border-primary bg-background rounded-2xl shadow-lg max-w-sm hover:shadow-xl transition duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <p class="font-alata text-primary font-semibold text-xl">Meja {{ $table ->No_Table }}</p>
                            <p class="text-xs font-semibold px-3 py-1 bg-secondary text-primary rounded-full">{{ $table ->status_table }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="w-full h-11 border-4 border-primary rounded-xl rounded-bl-3xl 
                                    px-4 py-2 outline-none transition-all focus:border-secondary duration-300 ease-in-out
                                    placeholder-gray-500 font-sans text-base">
                                    {{ $currentCustomer->Name ?? 'Data Tidak Ditemukan' }} 
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <p class="w-full h-11 border-4 border-primary rounded-xl rounded-bl-3xl 
                                    px-4 py-2 outline-none transition-all focus:border-secondary duration-300 ease-in-out
                                    placeholder-gray-500 font-sans text-base" >
                                    {{ $currentCustomer->Phone_Number ?? '-' }} 
                            </p>
                        </div>
                        
                        <div class="flex flex-col items-center">
                            @if ($customerId)
                            <form action="{{ route('order.index', ['table' => $table->No_Table, 'customer' => $customerId]) }}" method="GET" class="w-full">
                                <button type="submit" class="bg-primary hover:bg-red-900 transtion-all duration-600 text-background h-10 w-full rounded-lg text-sm font-semibold mb-1">
                                    Pesan Menu
                                </button>
                            </form>
                            @else
                            <button disabled class="bg-gray-400 text-background h-10 w-full rounded-lg text-sm font-semibold mb-1 cursor-not-allowed">
                                Customer Tidak Ditemukan
                            </button>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

@endsection