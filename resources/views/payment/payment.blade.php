@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')

<div class="min-h-screen w-full px-4 pt-6 pb-10 bg-gray-50" x-data="{ selectedMethod: 'Tunai' }">
    
    <h1 class="text-3xl font-alata text-primary mb-8 border-b pb-2">Proses Pembayaran Order TRX-{{ $order->Order_id }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-2xl font-alata text-gray-800 mb-4">Rincian Order</h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 pb-4 border-b">
                <div>
                    <p class="text-sm text-gray-500">Meja</p>
                    <p class="font-bold text-xl text-primary">{{ $order->nomor_meja }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Customer</p>
                    <p class="font-semibold text-lg text-gray-700 truncate">{{ $order->nama_customer }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pelayan</p>
                    <p class="font-semibold text-lg text-gray-700">{{ $order->nama_pelayan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold text-lg text-red-500">{{ $order->status_order }}</p>
                </div>
            </div>

            <h3 class="font-bold text-gray-700 mb-3 text-lg">Daftar Item:</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-3 custom-scrollbar">
                @foreach ($items as $item)
                    <div class="flex justify-between items-start pb-2 border-b border-gray-100 last:border-b-0">
                        <div>
                            <p class="font-medium text-gray-800">
                                <span class="font-bold text-primary">{{ $item->jumlah_pesanan }}x</span> {{ $item->nama_menu }}
                            </p>
                            @if($item->catatan)
                                <p class="text-xs text-red-500 italic ml-1">Catatan: {{ $item->catatan }}</p>
                            @endif
                        </div>
                        <span class="font-bold text-lg text-gray-800 flex-shrink-0 ml-4">
                            {{ 'Rp ' . number_format($item->harga_satuan, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-6 bg-white p-6 rounded-xl shadow-2xl border-4 border-primary">
                <h2 class="text-2xl font-alata text-primary mb-4">Total & Pembayaran</h2>
                
               <div class="font-alata text-gray-800 space-y-2">
    
    <div class="flex justify-between text-xl sm:text-xl">
        <span>Subtotal:</span>
        <span>{{ 'Rp ' . number_format($order->total_harga_kotor, 0, ',', '.') }}</span>
    </div>
    
    <div class="flex justify-between text-xl sm:text-xl">
        <span>Pajak (11%):</span>
        <span>{{ 'Rp ' . number_format($order->jumlah_pajak, 0, ',', '.') }}</span>
    </div>
    
    <hr class="border-gray-300"> 

    <div class="flex justify-between font-bold text-2xl sm:text-3xl pt-2">
        <span>TOTAL :</span>
        <span class="text-primary total-tagihan-display">{{ 'Rp ' . number_format($order->total_harga_bersih, 0, ',', '.') }}</span>
    </div>
    
</div>
                <form id="payment-form" method="POST" action="{{ route('payment.konfirmasi') }}" class="mt-6">
                    @csrf
                    {{-- @method('PUT')  --}}
                    <input type="hidden" name="Transaction_id" value="{{ $transaction->Transaction_id }}">

                    <div class="mb-4">
                        <label for="Method_Payment" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select name="Method_Payment" id="Method_Payment" required x-model="selectedMethod"
                            class="w-full border-gray-300 rounded-lg shadow-sm p-3 font-semibold text-lg focus:border-green-500 focus:ring-green-500 transition">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Kartu">Kartu Debit</option>
                            <option value="Transfer">Transfer Bank</option>
                        </select>
                    </div>

                    <div class="mt-5 p-4 rounded-xl border border-dashed border-gray-400 bg-gray-50" 
                         x-show="selectedMethod !== 'Tunai'">

                        <h3 class="font-bold text-lg mb-3 text-gray-700">Info Pembayaran:</h3>

                        <div x-show="selectedMethod === 'QRIS'" x-cloak>
                            <p class="text-sm text-gray-600 mb-2">Scan QR code di bawah ini.</p>
                            <div class="flex justify-center p-3 border rounded-lg bg-white">
                                
                                <img src="{{ asset('images/qris.jpg') }}" alt="QRIS Code" class="w-40 h-40 object-contain mx-auto">
                            </div>
                            <p class="text-xs text-center text-gray-500 mt-2">Pastikan jumlah yang ditransfer sesuai dengan total tagihan.</p>
                        </div>

                        <div x-show="selectedMethod === 'Transfer' || selectedMethod === 'Kartu'" x-cloak>
                            <p class="text-sm text-gray-600 mb-2">Lakukan pembayaran ke rekening atau EDC berikut:</p>
                            <div class="space-y-2 bg-white p-3 rounded-lg border">
                                <p class="font-medium text-gray-800">
                                    Bank: <span class="font-bold text-primary">BCA / MANDIRI</span>
                                </p>
                                <p class="font-medium text-gray-800">
                                    No. Rek: <span class="font-bold text-primary">123-456-7890</span>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Atas Nama: Ayam Pecak Joko Moro
                                </p>
                            </div>
                            <p class="text-xs text-center text-gray-500 mt-2" x-show="selectedMethod === 'Kartu'">
                                Gunakan mesin EDC yang tersedia di kasir.
                            </p>
                        </div>
                    </div>
                    
                    <button type="submit" id="pay-button"
                        class="bg-primary w-full py-3 rounded-xl text-white font-alata font-bold text-lg hover:bg-accent transition shadow-lg mt-6 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        <span class="flex items-center justify-center">
                            Konfirmasi Pembayaran
                        </span>
                    </button>
                </form>
            </div>
        </div>  
    </div>
</div>
@endsection