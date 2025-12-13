@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')

<div class="min-h-screen w-full px-4 pt-4 pb-10 bg-gray-50">
    
    <h1 class="text-3xl font-alata text-primary mb-8 border-b pb-2">Proses Pembayaran Order TRX-{{ $order->Order_id }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-2xl font-alata text-gray-800 mb-4">Rincian Order</h2>
            
            <div class="grid grid-cols-2 gap-4 mb-6 pb-4 border-b">
                <div>
                    <p class="text-sm text-gray-500">Meja</p>
                    <p class="font-bold text-xl text-primary">{{ $order->nomor_meja }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Customer</p>
                    <p class="font-semibold text-lg text-gray-700">{{ $order->nama_pembeli }}</p>
                </div>
            </div>

            <h3 class="font-semibold text-gray-700 mb-3 text-lg">Daftar Item:</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-3">
                @foreach ($items as $item)
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100 last:border-b-0">
                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $item->jumlah_pesanan }}x **{{ $item->nama_menu }}**
                            </p>
                            @if($item->catatan)
                                <p class="text-xs text-red-500 italic">Catatan: {{ $item->catatan }}</p>
                            @endif
                        </div>
                        <span class="font-bold text-md flex-shrink-0 ml-4">
                            {{ 'Rp ' . number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-4 bg-white p-6 rounded-xl shadow-2xl border-4 border-[#D4A017]">
                <h2 class="text-2xl font-alata text-[#D4A017] mb-4">Total & Pembayaran</h2>
                
                <div class="flex justify-between font-alata font-bold text-2xl text-gray-800 border-t pt-4">
                    <span>Total Tagihan:</span>
                    <span class="text-[#D4A017] total-tagihan-display">{{ 'Rp ' . number_format($transaction->Total_Price, 0, ',', '.') }}</span>
                </div>
                
                <form id="payment-form" method="POST" action="{{ route('payment.konfirmasi') }}" class="mt-6">
                    @csrf
                    @method('PUT') 
                    <input type="hidden" name="Transaction_id" value="{{ $transact  ion->Transaction_id }}">

                    <div class="mb-4">
                        <label for="Method_Payment" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select name="Method_Payment" id="Method_Payment" required
                            class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:border-green-500 focus:ring-green-500 transition">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Kartu">Kartu Debit/Kredit (Manual)</option>
                        </select>
                    </div>
                    
                    <button type="submit" id="pay-button"
                        class="bg-green-600 w-full py-3 rounded-xl text-white font-alata font-bold text-lg hover:bg-green-700 transition shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Konfirmasi Pembayaran
                        </span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection