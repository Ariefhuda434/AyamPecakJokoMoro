@extends('layouts.app')

@section('title', 'Status Pembayaran')

@section('content')

<div class="min-h-screen w-full flex items-center justify-center p-4 bg-gray-50">
    <div class="max-w-xl w-full bg-white p-8 rounded-xl shadow-2xl border-t-8 border-{{ $statusColor }}-500">
        
        <div class="text-center mb-6">
            @if ($snapStatus == 'success')
                <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @elseif ($snapStatus == 'pending')
                <svg class="w-20 h-20 text-yellow-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            @else
                <svg class="w-20 h-20 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @endif
            
            <h1 class="text-3xl font-bold mt-4 text-gray-800">{{ $statusText }}</h1>
            <p class="text-sm text-gray-500 mt-1">Order ID Lokal: **{{ $transaction->Order_id }}**</p>
        </div>

        <div class="border-t border-b py-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 font-medium">Total Tagihan</span>
                <span class="text-xl font-extrabold text-primary">{{ 'Rp ' . number_format($transaction->Total_Price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Nomor Meja</span>
                <span class="font-semibold">{{ $transaction->order->nomor_meja ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Dibuat Oleh Kasir</span>
                <span class="font-semibold">{{ $transaction->employee->Name_Employee ?? 'N/A' }}</span>
            </div>
        </div>

        @if ($snapStatus == 'pending')
            <p class="text-center text-yellow-600 bg-yellow-100 p-3 rounded-lg mb-4 text-sm">
                Pembayaran menunggu penyelesaian dari pelanggan (misalnya: transfer bank, QRIS). Status akan diperbarui secara otomatis oleh sistem kami (melalui Webhook).
            </p>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('cashier.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Kembali ke Dashboard Transaksi
            </a>
        </div>

    </div>
</div>
@endsection