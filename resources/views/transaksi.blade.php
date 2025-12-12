@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

<div class="min-h-screen w-full px-4 pt-4 pb-10" x-data="transactionData()">
    <h1 class="text-3xl font-alata text-primary mb-6">Daftar Transaksi Aktif</h1>

    <div class="w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        
        @forelse ($transaksiData as $transaksi)
        @php
            $nomorHp = $transaksi->nomor_hp ?? 'N/A';
            
            $isItemSelected = isset($selectedTransaction) && $selectedTransaction->Order_id === $transaksi->Order_id;
            $cardClasses = $isItemSelected 
                ? 'border-primary shadow-xl scale-[1.01]' 
                : 'border-gray-200 hover:border-secondary';
        @endphp
        
        <form 
           class="block bg-white border-4 p-5 rounded-xl shadow-lg cursor-pointer transition-all duration-300 ease-in-out {{ $cardClasses }}">
           <p class="font-alata text-2xl font-bold">Meja: {{ $transaksi->nomor_meja }}</p>
            
            <div class="flex items-center gap-2 mt-1 text-lg">
                <p class="text-primary font-semibold">{{ $transaksi->nama_customer }}</p> 
                <span class="text-gray-400">|</span>
                <p class="text-gray-600 text-sm">{{ $nomorHp }}</p>
            </div>
            
            <div class="mt-3 text-sm border-t pt-2">
                <p class="font-semibold text-gray-700 mb-1">Daftar Pesanan:</p>
                <ul class="list-disc list-inside space-y-1 text-gray-700">
                    
                    @forelse ($transaksi->items as $item)
                        {{ $item->jumlah_pesanan }} x {{ $item->nama_menu }}
                        <span class="text-gray-500 text-xs">
                            ({{ 'Rp ' . number_format($item->harga_satuan * $item->jumlah_pesanan, 0, ',', '.') }})
                            @if(!empty($item->catatan))
                                - Catatan: {{ $item->catatan }}
                            @endif
                        </span>
                    @empty
                    <li class="text-red-500 font-medium">Tidak ada pesanan</li>
                    @endforelse
                </ul>
            </div>
            
            <p class="text-sm text-gray-500 mt-3">Status: <span class="font-medium text-red-500">{{ $transaksi->status_order }}</span></p>
            <p class="text-sm text-gray-500">Pelayan: <span class="font-medium text-gray-700">{{ $transaksi->nama_pelayan }}</span></p>
            
            <p class="mt-4 text-xl font-alata font-bold text-gray-700 border-t pt-2">
                Total: {{ 'Rp ' . number_format($transaksi->total_harga, 0, ',', '.') }}
            </p>
             <button 
            type="submit" 
            class="bg-primary w-full py-3 rounded-[10px] text-background  mt-3 hover:bg-red-900 transition font-alata">
            Bayar
        </button>  
        </form>
        @empty
            <div class="sm:col-span-4 text-center py-10 text-gray-500">
                <p class="text-xl">Tidak Ada Order Menunggu Pembayaran. 🎉</p>
            </div>
        @endforelse
    </div>
</div>
@endsection