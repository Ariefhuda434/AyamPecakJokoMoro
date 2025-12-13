@extends('layouts.app')

@section('title', 'Order Berhasil Dibuat')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-xl mx-auto bg-white p-10 rounded-2xl shadow-2xl  transform hover:scale-[1.01] transition duration-500 ease-in-out">
        
        <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-primary mb-4 animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h1 class="text-4xl font-alata text-gray-800 mb-2 font-bold">Pesanan Selesai!</h1>
            <p class="text-lg text-primary mb-8">Order Anda telah berhasil dikirim ke dapur.</p>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8">
            <h2 class="text-xl font-alata text-gray-700 mb-3 border-b pb-2">Rincian Order</h2>
            <div class="flex justify-between text-gray-600 mb-2">
                <span class="font-semibold">ID Transaksi:</span>
                <span class="font-alata text-lg text-primary font-extrabold">{{ $order->Order_id }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Status Stok:</span>
                <span class="text-sm text-gray-500">Bahan baku telah diperbarui.</span>
            </div>
        </div>

        <div class="space-y-4">
            
            <a href="{{ route('order.print', $order->Order_id) }}" 
                target="_blank" 
                class="w-full inline-flex items-center justify-center bg-primary hover:bg-red-900 text-white font-bold py-3 px-6 rounded-xl transition duration-300 shadow-md transform hover:shadow-lg "
            >
                <i class="fas fa-print mr-3"></i> 
                Cetak Struk & Notifikasi Dapur (PDF)
            </a>
            
            <a href="{{ route('customer.index') }}" 
                class="w-full block text-center text-primary border border-primary hover:bg-primary hover:text-white font-semibold py-2 px-6 rounded-xl transition duration-300"
            >
                Kembali ke Daftar Meja
            </a>
        </div>
        
    </div>
</div>
@endsection