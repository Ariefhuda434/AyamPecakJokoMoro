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
                    <span class="text-primary total-tagihan-display">{{ 'Rp ' . number_format($transaction->Total_Price, 0, ',', '.') }}</span>
                </div>
                
                <form id="payment-form" method="POST" action="#" class="mt-6">
                    @csrf
                    <input type="hidden" name="Order_id" value="{{ $order->Order_id }}">
                    <input type="hidden" name="Transaction_id" value="{{ $transaction->Transaction_id }}">
                    <input type="hidden" name="Total_Price" value="{{ $transaction->Total_Price }}">
                    <input type="hidden" name="Employee_id" value="{{ $order->Employee_id }}">
                    <input type="hidden" name="snap_token" value="{{ $transaction->snap_token }}"> 

                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" required
                            class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:border-primary focus:ring-primary transition">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Kartu">Kartu Debit/Kredit (Manual)</option>
                        </select>
                    </div>
                    
                    <div class="mb-6 tunai-fields">
                        <label for="paid_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar Diterima (Tunai)</label>
                        <input type="number" name="paid_amount" id="paid_amount" 
                            min="{{ $transaction->Total_Price }}"
                            value="{{ $transaction->Total_Price }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm p-4 text-2xl font-bold text-gray-800 focus:border-green-500 focus:ring-green-500 transition" 
                            placeholder="{{ $transaction->Total_Price }}">
                    </div>

                    <button type="submit" id="pay-button"
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
@php
    $midtransUrl = config('midtrans.is_production') 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp
<script src="{{ $midtransUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const paymentMethodSelect = document.getElementById('payment_method');
        const paidAmountField = document.getElementById('paid_amount');
        const form = document.getElementById('payment-form');
        const totalHarga = {{ $transaction->Total_Price }};
        const snapToken = '{{ $transaction->snap_token }}';

   
        function toggleTunaiFields() {
            if (paymentMethodSelect.value === 'Tunai') {
                paidAmountField.closest('.tunai-fields').style.display = 'block';
                paidAmountField.setAttribute('required', 'required');
                payButton.textContent = 'Konfirmasi Pembayaran Tunai';
            } else {
               
                paidAmountField.closest('.tunai-fields').style.display = 'none';
                paidAmountField.removeAttribute('required');
                paidAmountField.value = totalHarga; 
                payButton.textContent = 'Lanjut ke Pembayaran Online';
            }
        }

        paymentMethodSelect.addEventListener('change', toggleTunaiFields);
        toggleTunaiFields(); 

        
        payButton.addEventListener('click', function(event) {
            const selectedMethod = paymentMethodSelect.value;

            if (selectedMethod === 'QRIS' || selectedMethod === 'Kartu') { 
                event.preventDefault();
                
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        alert('Pembayaran Berhasil! Mengarahkan...');
                        window.location.href = "{{ route('cashier.paymentStatus') }}?transaction_id={{ $transaction->Transaction_id }}&status=success";
                    },
                    onPending: function(result) {
                        alert('Pembayaran Pending. Mohon tunggu notifikasi!');
                        window.location.href = "{{ route('cashier.paymentStatus') }}?transaction_id={{ $transaction->Transaction_id }}&status=pending";
                    },
                    onError: function(result) {
                        alert('Pembayaran Gagal!');
                        window.location.href = "{{ route('cashier.paymentStatus') }}?transaction_id={{ $transaction->Transaction_id }}&status=failure";
                    },
                    onClose: function() {
                        alert('Anda menutup pop-up. Transaksi dibatalkan.');
                    }
                });

            } else if (selectedMethod === 'Tunai') {
                if (parseInt(paidAmountField.value) < totalHarga) {
                    event.preventDefault();
                    alert('Jumlah bayar Tunai harus lebih besar atau sama dengan Total Tagihan!');
                }
            } else {
                event.preventDefault(); 
                alert('Silakan proses pembayaran menggunakan terminal eksternal dan konfirmasi status di backend.');
            }
        });

    });
</script>
@endsection