@extends('layouts.app')

@section('title', 'Manajemen Meja')

@section('content')

<div class="container mx-auto p-6">
     <a href="{{ route('dashboard.view') }}" class="mr-3 text-primary hover:text-secondary transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
    </a>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Meja</h1>
        
        <form action="{{ route('make.table') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="bg-secondary text-white px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-accent transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Meja Baru 
            </button>
        </form>
    </div>

    @php
        $totalTables = $tables->count();
        $occupiedTables = $tables->where('status_table', 'Terisi')->count();
        $availableTables = $totalTables - $occupiedTables;
    @endphp
    
    <div class="flex gap-4 mb-10 border-b pb-8">
        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition duration-300 w-full">
            <p class="text-base text-gray-500 font-semibold mb-1">Total Meja</p>
            <p class="text-4xl font-extrabold text-gray-900">{{ $totalTables }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition duration-300 w-full">
            <p class="text-base text-gray-500 font-semibold mb-1">Meja Kosong</p>
            <p class="text-4xl font-extrabold text-gray-900">{{ $availableTables }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition duration-300 w-full">
            <p class="text-base text-gray-500 font-semibold mb-1">Meja Terisi</p>
            <p class="text-4xl font-extrabold text-gray-900">{{ $occupiedTables }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @foreach ($tables as $table)
            @php
                $statusColor = $table->status_table == 'Terisi' ? 'bg-white border-5 border-primary' : 'bg-white border-secondary border-5';
                $iconClass = $table->status_table == 'Terisi' ? 'text-secondary' : 'text-primary';
            @endphp
            
            <div class="{{ $statusColor }} border-2 rounded-lg p-4 shadow-lg flex flex-col items-center justify-center">
            
                <img src="{{ asset('images/kosong.png') }}" class="bg-secondary h-15 w-15 rounded-full p-3" alt="" srcset="">

                <h3 class="text-xl font-extrabold text-gray-800">Meja {{ $table->No_Table }}</h3>
                
                <p class="text-sm font-semibold mt-1 {{ $iconClass }}">{{ $table->status_table }}</p>
                
                <div class="mt-3 flex space-x-2">
                    <form action="{{ route('table.destroy', $table->No_Table) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konfigurasi Meja {{ $table->No_Table }} secara permanen? Tindakan ini tidak dapat diulang.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                @if ($table->status_table == 'Terisi') 
                                    disabled title="Tidak bisa dihapus saat terisi" 
                                    class="text-xs bg-gray-200 text-gray-400 px-3 py-1 rounded cursor-not-allowed"
                                @else 
                                    class="text-xs bg-secondary text-gray-800 px-3 py-1 rounded hover:bg-accent hover:text-white transition"
                                @endif>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection