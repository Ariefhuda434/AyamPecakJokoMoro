@extends('layouts.app')

@section('title', 'Pemesanan')

@section('content')

    <div class="min-h-screen w-full px-4 pt-4 pb-10">

        <div class="flex items-center mb-6">
            <div class="h-12 w-12 bg-primary rounded-full mr-3"></div>
            
            <h1 class="text-primary font-alata text-2xl mr-auto">Pemesanan</h1>
            
            <span class="h-5 w-5 bg-secondary rounded-full mr-4"></span>
            <span class="h-9 w-0.5 bg-primary rounded-full mr-4"></span>
            
            <div class="h-12 w-12 bg-white rounded-full border-2 border-text-bg-1"></div>
        </div>
        
        <hr class="mb-6 border-gray-200">

        <div class="flex  justify-start gap-4 mb-8">
            <div class="flex items-center p-4 w-52 bg-secondary rounded-2xl shadow-md">
                <div class="h-10 w-10 bg-white mr-3 rounded-md"></div>
                
                <div>
                    <p class="text-background font-alata text-lg flex items-center">
                        Semua
                        <span class="ml-2 h-4 w-4 bg-black rounded-sm"></span>
                    </p>
                    <p class="text-sm">115 items</p>
                </div>
            </div>
            
            <div class="flex items-center p-4 w-52 bg-primary rounded-2xl shadow-md">
                <div class="h-10 w-10 bg-white mr-3 rounded-md"></div>
                
                <div>
                    <p class="text-background font-alata text-lg flex items-center">
                        Status
                        <span class="ml-2 h-4 w-4 bg-background rounded-sm"></span>
                    </p>
                    <p class="text-background text-sm">Kosong</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap justify-start gap-6 mt-4">
        @foreach ($tables as $table) 
        <div class="w-full p-4 bg-white border-4 border-gray-300 rounded-2xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <p class="font-alata text-gray-500 text-xl">Meja {{ $table ->No_Table }}</p>
                <p class="text-xs font-semibold px-3 py-1 bg-red-100 text-red-700 rounded-full">{{ $table ->status_table }}</p>
            </div>
            
            <form action="{{ route('make.customer', $table->No_Table) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="Name" placeholder="Nama" value="{{ old('Name') }}"
                        class="w-full h-11 border-4 border-gray-300 rounded-xl rounded-bl-3xl 
                            px-4 outline-none transition-all focus:border-secondary duration-300 ease-in-out
                            placeholder-gray-500 font-sans text-base" />
                </div>
                
                <div class="mb-4">
                    <input type="text" name="Phone_Number" placeholder="Nomor HP" value="{{ old('Phone_Number') }}"
                        class="w-full h-11 border-4 border-gray-300 rounded-xl rounded-bl-3xl 
                            px-4 outline-none transition-all focus:border-secondary duration-300 ease-in-out
                            placeholder-gray-500 font-sans text-base" />
                </div>
                <div class="flex flex-col items-center">
                    <button type="submit" class="bg-gray-400 text-background h-10 w-full rounded-lg text-sm font-semibold mb-1">
                        Pesan
                    </button>
                    <a href="#" class="underline text-xs text-gray-500 hover:text-red-500 transition duration-300">
                        Pesan Sekarang
                    </a>
                </div>
            </form>
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