@extends('layouts.app')

@section('title', 'Pemesanan')

@section('content')

    <div class="min-h-screen w-full px-4 pt-4 pb-10">
        <div class="flex gap-5">
        <a href="{{ route('customer.index') }}" class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <div class="h-15 w-15 bg-white mr-3 rounded-md"></div>
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Semua Meja</p>
                    <p class="font-alata text-lg font-bold">{{ $totalTables }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('customer.index',['status_table' => 'Kosong']) }}" class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <div class="h-15 w-15 bg-white mr-3 rounded-md"></div>
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Meja Kosong</p>
                    <p class="font-alata text-lg font-bold">{{ $availableTables }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('customer.index',['status_table' => 'Terisi']) }}" class="flex gap-4 mb-8">
            <div class="flex p-4 w-53 h-23 bg-secondary text-primary rounded-2xl shadow-md hover:text-background transition-all duration-400 hover:scale-[1.02] hover:shadow-lg ease-in-out hover:bg-primary shadow-md">
                <div class="h-15 w-15 bg-white mr-3 rounded-md"></div>
                <div class="flex flex-col">
                    <p class="font-alata text-lg">Meja Terisi</p>
                    <p class="font-alata text-lg font-bold">{{ $occupiedTables }}</p>
                </div>
            </div>
        </a>

        </div>

        <div class="flex w-full border-t-1 pt-10 flex-wrap justify-start gap-6 mt-4">
        @foreach ($tables as $table) 
            @if ($table->status_table == 'Kosong')
        <div class="w-full p-4 bg-white border-4 border-gray-300 rounded-2xl shadow-lg max-w-sm">
            <div class="flex justify-between items-center mb-4">
                <p class="font-alata text-gray-500 text-xl">Meja {{ $table ->No_Table }}</p>
                <p class="text-xs font-semibold px-3 py-1 bg-red-100 text-red-700 rounded-full">{{ $table ->status_table }}</p>
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
                    <a href="#" class="underline text-xs text-gray-500 hover:text-red-500 transition duration-300">
                        Pesan Sekarang 
                    </a>
                </div>
            </form>

            @else
            @php
                $currentCustomer = $table->activeCustomer ?? null; 
                $customerId = $currentCustomer->Customer_id ?? null;
            @endphp
           
             <div class="w-full p-4 border-4 border-primary bg-background rounded-2xl shadow-lg max-w-sm">
            <div class="flex justify-between items-center mb-4">
                <p class="font-alata text-primary font-semibold text-xl">Meja {{ $table ->No_Table }}</p>
                <p class="text-xs font-semibold px-3 py-1 bg-green-500 text-primary rounded-full">{{ $table ->status_table }}</p>
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
                <form action="{{ route('order.index', [$table->No_Table, $customerId]) }}" method="GET" class="w-full">
                    @csrf
                    <button type="submit" class="bg-primary hover:bg-red-900 transtion-all duration-600 text-background h-10 w-full rounded-lg text-sm font-semibold mb-1">
                        Pesan Menu
                    </button>
                </form>
                @else
                <button disabled class="bg-gray-400 text-background h-10 w-full rounded-lg text-sm font-semibold mb-1 cursor-not-allowed">
                    Customer Tidak Ditemukan
                </button>
                @endif
                
                <form action="{{ route('customer.out', $table->No_Table) }}" method="POST">
                    @csrf
                    @method('PUT') 
                    <button type="submit" class="underline text-xs text-gray-500 hover:text-red-500 transition duration-300">
                        Batalkan Pesanan (Kosongkan Meja)
                    </button>
                </form>

                </div>
            @endif
        </div>
        @endforeach
            
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

    </div>

@endsection