@extends('layouts.app')

@section('title', 'Order Berhasil Dibuat')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-xl mx-auto bg-white p-10 rounded-2xl shadow-2xl  transform hover:scale-[1.01] transition duration-500 ease-in-out">
        
        <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-primary mb-4 animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h1 class="text-4xl font-alata text-gray-800 mb-2 font-bold">Transaksi Selesai!</h1>
            <p class="text-lg text-primary mb-8">Pembayaran Telah Selesai Dilakukan</p>
        </div>

      <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 mb-8">
    <h2 class="text-xl font-alata text-gray-700 mb-4 border-b pb-2">Rincian Item Pesanan</h2>
    
    <div class="space-y-4">
    
    @php $subtotal = 0; @endphp
    @foreach ($items as $item)
        @php 
            $itemTotal = $item->jumlah_pesanan * $item->harga_satuan;
            $subtotal += $itemTotal; 
        @endphp
        
        <div class="flex justify-between items-start pb-2 border-b border-gray-100 last:border-b-0">
            <div>
                <p class="font-medium text-gray-800">
                    <span class="font-bold text-primary">{{ $item->jumlah_pesanan }}x</span> {{ $item->nama_menu }}
                </p>
                @if($item->catatan)
                    <p class="text-xs text-red-500 italic ml-1">Catatan: {{ $item->catatan }}</p>
                @endif
            </div>
            
            <span class="font-bold text-base text-gray-800 flex-shrink-0 ml-4">
                {{ 'Rp ' . number_format($item->harga_satuan, 0, ',', '.') }}
            </span>
        </div>
    @endforeach
    
    <div class="mt-4 pt-4 border-t border-gray-300 font-alata">
        
        <div class="flex justify-between text-lg text-gray-700 mb-2">
            <span>Subtotal Pesanan:</span>
            <span>{{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between text-lg text-gray-700 mb-2">
            <span>Pajak 11%:</span>
            <span>{{ 'Rp ' . number_format($transaction->jumlah_pajak, 0, ',', '.') }}</span>
        </div>
        
        <div class="flex justify-between font-bold text-xl text-primary pt-1">
            <span>TOTAL BERSIH:</span>
            <span>{{ 'Rp ' . number_format($transaction->total_harga_bersih, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
</div>
        <div class="space-y-4">
            
            <a  href="{{ route('transaksi.print', ['transactionData' => $transaction->Transaction_id]) }}"
                target="_blank" 
                class="w-full inline-flex items-center justify-center bg-primary hover:bg-red-900 text-white font-bold py-3 px-6 rounded-xl transition duration-300 shadow-md transform hover:shadow-lg "
            >
                <i class="fas fa-print mr-3"></i> 
                Cetak Struk 
            </a>
            
            <a href="{{ route('cashier.view') }}" 
                class="w-full block text-center text-primary border border-primary hover:bg-primary hover:text-white font-semibold py-2 px-6 rounded-xl transition duration-300"
            >
                Kembali ke dashboard kasir
            </a>
        </div>
        
    </div>
</div>
@endsection