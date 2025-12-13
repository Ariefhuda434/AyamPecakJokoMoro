@extends('layouts.app')

@section('title', 'Order Berhasil')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-alata text-green-600 mb-4">✅ Order Berhasil Dibuat!</h1>
        <p class="text-xl text-gray-700 mb-6">Order ID: **{{ $order->Order_id }}**</p>
        
        <p class="text-gray-500 mb-8">Stok bahan baku telah diperbarui.</p>

        <a href="{{ route('order.print', $order->Order_id) }}" 
           target="_blank" 
           class="inline-block bg-primary hover:bg-red-900 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-md"
        >
            🖨️ Cetak Struk (PDF)
        </a>
        
        <a href="{{ route('customer.index') }}" 
           class="block mt-4 text-sm text-primary hover:underline"
        >
            Kembali ke Beranda / Daftar Meja
        </a>
    </div>
</div>
@endsection