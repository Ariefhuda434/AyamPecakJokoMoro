@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')

{{-- Data Dummy untuk simulasi transaksi yang dipilih --}}
@php
    $selectedTransaction = (object) [
        'Order_id' => 'ORD-20251213-001',
        'nomor_meja' => 7,
        'nama_customer' => 'Ani Suryani',
        'nama_pelayan' => 'Budi Kasir',
        'total_harga' => 175000,
        'items' => [
            (object)['nama_menu' => 'Nasi Goreng Spesial', 'jumlah_pesanan' => 2, 'harga_satuan' => 35000, 'subtotal' => 70000, 'catatan' => 'Pedas sedang'],
            (object)['nama_menu' => 'Es Jeruk', 'jumlah_pesanan' => 3, 'harga_satuan' => 15000, 'subtotal' => 45000, 'catatan' => null],
            (object)['nama_menu' => 'Ayam Bakar Madu', 'jumlah_pesanan' => 1, 'harga_satuan' => 60000, 'subtotal' => 60000, 'catatan' => 'Tanpa kulit'],
        ],
    ];
    $employeeId = 'EMP005';
@endphp

<div class="min-h-screen w-full px-4 pt-4 pb-10 bg-gray-50">
    
    <h1 class="text-3xl font-alata text-primary mb-8 border-b pb-2">Proses Pembayaran Order {{ $transaction->Order_id }}</h1>

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
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $item->jumlah_pesanan }}x {{ $item->nama_menu }}
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
            <div class="sticky top-4 bg-white p-6 rounded-xl shadow-2xl border-4 border-primary/50">
                <h2 class="text-2xl font-alata text-primary mb-4">Total & Pembayaran</h2>
                
                <div class="flex justify-between font-alata font-bold text-2xl text-gray-800 border-t pt-4">
                    <span>Total Tagihan:</span>
                    <span class="text-primary">{{ 'Rp ' . number_format($transaction->Total_Price, 0, ',', '.') }}</span>
                </div>
                
                <form method="POST" action="#" class="mt-6">
                    @csrf
                    @method('UPDATE')

                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" required
                            class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:border-primary focus:ring-primary transition">
                            <option value="Tunai">Tunai</option>
                            <option value="Kartu">Kartu Debit/Kredit</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer Bank</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label for="paid_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar Diterima</label>
                        <input type="number" name="paid_amount" id="paid_amount" required 
                            min="{{ $selectedTransaction->total_harga }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm p-4 text-2xl font-bold text-gray-800 focus:border-green-500 focus:ring-green-500 transition" 
                            placeholder="{{ $selectedTransaction->total_harga }}">
                    </div>

                    <button type="submit"  id="pay-button"
                        class="bg-green-500 w-full py-3 rounded-xl text-white font-alata font-bold text-lg hover:bg-green-600 transition shadow-md">
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

@section('scripts')
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY ') }}"></script>
  <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $transaction->snap_token }}', {
          onSuccess: function(result){
          },
          onPending: function(result){
          },
          onError: function(result){
          }
        });
      };
    </script>
@endsection