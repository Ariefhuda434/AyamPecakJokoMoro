@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 sm:p-8">
    <header class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 flex items-center">
            <svg class="w-8 h-8 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Dashboard Transaksi
        </h1>
        <p class="text-gray-600">Ringkasan transaksi hari ini dan formulir checkout pelanggan.</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Total Penjualan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp 12.500.000</p>
                    <span class="text-xs text-green-500 font-semibold">+8% dari kemarin</span>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Transaksi Baru</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">45</p>
                    <span class="text-xs text-red-500 font-semibold">-2 Transaksi</span>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Pelanggan Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">128</p>
                    <span class="text-xs text-blue-500 font-semibold">Pelanggan Reguler</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Transaksi Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelayan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX1001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Budi Santoso</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">M05</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rina</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-indigo-600">Rp 450.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX1002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Dewi Lestari</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">M12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Andi</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-indigo-600">Rp 1.200.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Tertunda</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX1003</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Ahmad Fauzi</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">M01</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rina</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-indigo-600">Rp 250.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#TRX1004</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Citra Kirana</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Takeaway</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Bambang</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-indigo-600">Rp 80.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-2xl border border-indigo-200 sticky top-4">
                <h2 class="text-2xl font-bold text-indigo-600 mb-6 border-b pb-3">🛒 Checkout Transaksi Baru</h2>
                
                <form class="space-y-4">
                    <div class="space-y-4 border-b pb-4">
                        <p class="text-md font-semibold text-gray-800">Detail Pelanggan & Layanan</p>

                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                            <input type="text" id="customer_name" name="customer_name" placeholder="Masukkan nama pelanggan" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="table_number" class="block text-sm font-medium text-gray-700">Nomor Meja</label>
                                <input type="text" id="table_number" name="table_number" placeholder="Contoh: M07" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <div>
                                <label for="server_name" class="block text-sm font-medium text-gray-700">Pelayan</label>
                                <input type="text" id="server_name" name="server_name" placeholder="Nama Pelayan" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <input type="tel" id="customer_phone" name="customer_phone" placeholder="Contoh: 08123456789" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="text-md font-semibold text-gray-800">Informasi Pembelian</p>
                    
                        <div>
                            <label for="items_description" class="block text-sm font-medium text-gray-700">Detail Produk/Layanan</label>
                            <textarea id="items_description" name="items_description" rows="2" placeholder="Contoh: 2x Kopi Latte, 1x Nasi Goreng" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div>
                            <label for="transaction_total" class="block text-sm font-medium text-gray-700">Total Transaksi (Rp)</label>
                            <input type="number" id="transaction_total" name="transaction_total" placeholder="Contoh: 500000" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 font-bold text-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                            <select id="payment_status" name="payment_status" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="pending">Tertunda (Pending)</option>
                                <option value="paid">Lunas (Paid)</option>
                                <option value="failed">Gagal (Failed)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out mt-6">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 3h.01M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m.01-.01V21h18v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16-16V5a2 2 0 00-2-2H7a2 2 0 00-2 2v1m14 0V5a2 2 0 00-2-2H7a2 2 0 00-2 2v1"></path></svg>
                        Proses Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection