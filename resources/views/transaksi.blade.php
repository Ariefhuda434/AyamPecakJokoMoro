@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

<div class="min-h-screen w-full px-4 pt-6 pb-10" x-data="transactionData()">
    <h1 class="text-3xl font-alata text-primary mb-8 border-b pb-3">Daftar Transaksi Aktif</h1>

    <div class="w-full">
        <div class="grid grid-cols-1  sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            @forelse ($transaksiData as $transaksi)
            @php
                $nomorHp = $transaksi->nomor_hp ?? 'N/A';
                
                $isItemSelected = isset($selectedTransaction) && $selectedTransaction->Order_id === $transaksi->Order_id;
                $cardClasses = $isItemSelected 
                    ? 'border-4 border-primary shadow-xl ring-2 ring-primary' 
                    : 'border border-gray-200 hover:border-secondary';
            @endphp
            
            <form method="POST" action="{{ route('cashier.pay') }}"
                class="block bg-white p-5 rounded-xl border-10 border-primary hover:scale-101 hover:shadow-lg shadow-md cursor-pointer transition-all duration-300 ease-in-out {{ $cardClasses }}">
                
                @csrf
                <input value="{{ $transaksi->Order_id }}" hidden name="Order_id">
                <input value="{{ $transaksi->Employee_id }}" hidden name="Employee_id">
                <input value="{{ $transaksi->total_harga_kotor }}" hidden name="Total_Price">

                <div class="mb-4">
                    <p class="font-alata text-3xl font-extrabold text-primary">Meja: {{ $transaksi->nomor_meja }}</p>
                    <div class="flex items-center gap-2 mt-1 text-base">
                        <p class="text-gray-800 font-semibold">{{ $transaksi->nama_customer }}</p> 
                        <span class="text-gray-400">|</span>
                        <p class="text-gray-500 text-sm">{{ $nomorHp }}</p>
                    </div>
                </div>
                
                <div class="mt-4 text-sm border-t pt-3">
                    <p class="font-bold text-gray-700 mb-2 flex items-center">
                        Daftar Pesanan ({{ count($transaksi->items) }} Item)
                    </p>
                    <ul class="space-y-1 text-gray-700 max-h-24 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse ($transaksi->items as $item)
                        <li class="flex justify-between items-start text-sm border-b border-gray-100 pb-1">
                            <span class="text-gray-800 font-medium break-words pr-2">
                                {{ $item->jumlah_pesanan }}x {{ $item->nama_menu }}
                            </span>
                            <span class="text-xs font-semibold text-gray-600 flex-shrink-0 whitespace-nowrap">
                                {{ 'Rp ' . number_format($item->harga_satuan * $item->jumlah_pesanan, 0, ',', '.') }}
                            </span>
                        </li>
                        @if(!empty($item->catatan))
                            <p class="text-xs text-red-500 italic ml-2 -mt-1 mb-1">
                                Catatan: {{ $item->catatan }}
                            </p>
                        @endif
                        @empty
                        <li class="text-red-500 font-medium text-center">Tidak ada pesanan</li>
                        @endforelse
                    </ul>
                </div>
                
                <div class="mt-4 text-sm border-t pt-3">
                    <p class="text-gray-500">
                        Status: <span class="font-bold text-red-600">{{ $transaksi->status_order }}</span>
                    </p>
                    <p class="text-gray-500">
                        Pelayan: <span class="font-medium text-gray-700">{{ $transaksi->nama_pelayan }}</span>
                    </p>
                </div>
                
                <p class="mt-4 text-2xl font-alata font-extrabold text-primary border-t pt-3">
                    Total: {{ 'Rp ' . number_format($transaksi->total_harga_kotor, 0, ',', '.') }}
                </p>
                
                <button 
                    type="submit" 
                    class="bg-primary w-full py-3 rounded-xl text-white mt-4 hover:bg-accent transition font-alata font-bold text-lg shadow-md">
                    Proses Pembayaran
                </button> 
            </form>
            @empty
            <div class="col-span-full text-center py-20 bg-gray-50 rounded-xl shadow-inner">
                <p class="text-2xl font-alata text-gray-500">Tidak Ada Order Menunggu Pembayaran.</p>
                <p class="text-gray-400 mt-2">Semua transaksi saat ini sudah selesai atau belum dibuat. 🎉</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection