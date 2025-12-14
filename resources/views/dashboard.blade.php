@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    $penjualanHariIni = $penjualanHariIni ?? 0;
    $tanggalHariIni = $tanggalHariIni ?? 'Tanggal Hari Ini';
    $pendapatanBulanIni = $pendapatanBulanIni ?? 'Rp 0';
    $tahunBulanSekarang = $tahunBulanSekarang ?? 'Bulan Ini';
    $mejaTerpakai = $mejaTerpakai ?? 0;
    $mejaTotal = $mejaTotal ?? 0;
    $customerActivitySummary = $customerActivitySummary ?? collect();
    $menuData = $menuData ?? collect();
    $chartPendapatan = $chartPendapatan ?? [];
    $chartPenjualan = $chartPenjualan ?? [];
@endphp

<div class="min-h-screen bg-gray-50 p-6 md:p-10 font-alata">
    <h1 class="text-3xl font-alata font-bold text-gray-800 mb-6">Ringkasan Dashboard Operasional</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-5 rounded-xl shadow-lg border-t-4 border-red-600 transform transition duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-medium text-gray-500">Rekap Penjualan Hari Ini</h3>
                <span class="text-xl text-red-600">
                    <i class="fas fa-shopping-cart w-6 h-6"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">
    RP {{ number_format($penjualanHariIni->Total_Penjualan, 0, ',', '.') }} 
</p>
            <p class="text-xs text-gray-400">{{ $tanggalHariIni }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-lg border-t-4 border-green-600 transform transition duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-medium text-gray-500">Pendapatan Bulanan</h3>
                <span class="text-xl text-green-600">
                    <i class="fas fa-wallet w-6 h-6"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">
    RP {{ number_format($pendapatanBulanIni->Total_Pendapatan_Bulan ?? 0, 0, ',', '.') }}
</p>
            <p class="text-xs text-gray-400">{{ $tahunBulanSekarang }}</p>
        </div>

        <form action="{{ route('table.index') }}" method="GET">
            <button type="submit" class="bg-white p-5 rounded-xl w-full h-full text-left shadow-lg border-t-4 border-blue-600 transform transition duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-medium text-gray-500">Meja Terpakai Saat Ini</h3>
                    <span class="text-xl text-blue-600">
                        <i class="fas fa-chair w-6 h-6"></i>
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $mejaTerpakai}} Meja</p>
                <p class="text-xs text-gray-400">Total {{ $mejaTotal }} Meja yang tersedia</p>
            </button>
        </form>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-4">
                <h2 class="text-xl font-alata font-bold text-gray-800 flex items-center">
                    <i class="fas fa-bell mr-2 text-red-500"></i> Ringkasan Aktivitas Operasional
                </h2>
                <a href="{{ route('log.index') }}" class="text-sm font-semibold text-gray-500 hover:text-red-600 transition">
                    Lihat Log Penuh &rarr;
                </a>
            </div>

            <ul class="space-y-4">
                @forelse ($customerActivitySummary->take(6) as $activity) 
                    <li class="flex justify-between items-start py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-start space-x-3">
                            <i class="{{ $activity['icon'] }} text-xl pt-1"></i> 
                            
                            <div class="flex flex-col">
                                <p class="font-medium text-gray-800 leading-snug">
                                    {!! $activity['description'] !!} 
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Pelaku: **{{ $activity['employee'] }}**
                                </p>
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-400 whitespace-nowrap ml-4 pt-1">
                            {{ $activity['time_ago'] }}
                        </p>
                    </li>
                @empty
                    <p class="text-center text-gray-500 py-6">
                        <i class="fas fa-box-open mr-2"></i> Belum ada aktivitas operasional pelanggan/transaksi yang tercatat.
                    </p>
                @endforelse
            </ul>
        </div> 
        
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-4">
                <h2 class="text-xl font-alata font-bold text-gray-800 flex items-center">
                    <i class="fas fa-fire-alt mr-2 text-orange-500"></i> Manejemen Menu
                </h2>
                <form action="{{ route('menu.index') }}" method="get">
                    <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-primary transition">Lihat Menu &rarr;</button>
                </form>
            </div>
            
            @forelse($menuData->take(4) as $data) 
            <div class="flex items-center py-3 border-b border-gray-100 last:border-b-0">

    <div class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 mr-4 overflow-hidden rounded-lg shadow-md">
        <img src="{{ asset('storage/' . $data->foto_menu) }}" 
             alt="{{ $data->nama_menu }}" 
             class="w-full h-full object-cover transition duration-300 transform hover:scale-105"
        >
    </div>
    <div class="flex-grow min-w-0">
        <p class="font-semibold text-gray-800 truncate">{{ $data->nama_menu }}</p>
        <p class="text-sm font-bold text-gray-900">{{ number_format($data->harga, 0, ',', '.') }}</p>
    </div>

    <div class="flex-shrink-0 ml-4 text-right">
        <p class="text-sm text-green-600 font-semibold">{{ $data->status_menu }}</p>
    </div>
</div>
            @empty
            <p class="text-center text-gray-500 py-6 text-sm">Tidak ada data menu populer.</p>
            @endforelse
        </div>
    </div> 

    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-6">
            <h2 class="text-xl font-bold text-gray-800">Ringkasan Penjualan dan Pendapatan Tahunan</h2>
            <div class="flex items-center space-x-3">
                <form action="{{ route('export') }}" method="GET"> 
                    <button type="submit" class="flex items-center text-sm font-semibold text-white bg-green-600 px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-md">
                        <i class="fas fa-file-excel w-4 h-4 mr-1"></i>
                        Export Data (Excel)
                    </button>
                </form>
            </div>
        </div>

        <div class="flex space-x-6 mb-4">
            <div class="flex items-center text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                Penjualan (Sales)
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                Pendapatan (Revenue)
            </div>
        </div>
        

        <div class="h-64 border border-gray-200 rounded-lg p-4 flex items-center justify-center bg-gray-50">
            <canvas id="PenjualanChart"></canvas>
        </div>
        
        <div class="flex justify-between mt-4 text-xs text-gray-500 px-2">
            <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MAY</span><span>JUN</span><span>JUL</span><span>AUG</span><span>SEP</span><span>OCT</span><span>NOV</span><span>DEC</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    const pendapatan = @json($chartPendapatan);
    const penjualan = @json($chartPenjualan); 

    const chartArea = document.getElementById('PenjualanChart').parentElement;
    if (pendapatan.length === 0 && penjualan.length === 0) {
        chartArea.innerHTML = 
            '<p class="text-gray-400 text-center py-10">Tidak ada data penjualan tahunan yang tersedia untuk ditampilkan.</p>';
        return;
    }

    const ctx = document.getElementById('PenjualanChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line', 
        data: {
            labels: labels, 
            datasets: [
                {
                    label: 'Penjualan (Sales/Transaksi)',
                    data: penjualan, 
                    backgroundColor: 'rgba(59, 130, 246, 0.5)', 
                    borderColor: '#3b82f6', // blue-500
                    pointBackgroundColor: '#3b82f6',
                    tension: 0.3, 
                    fill: false,
                    yAxisID: 'y1', // Sumbu Y Kanan (Transaksi)
                },
                {
                    label: 'Pendapatan (Revenue)',
                    data: pendapatan, 
                    backgroundColor: 'rgba(239, 68, 68, 0.5)', 
                    borderColor: '#ef4444', // red-500
                    pointBackgroundColor: '#ef4444',
                    tension: 0.3,
                    fill: false,
                    yAxisID: 'y', // Sumbu Y Kiri (Rupiah)
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                // Format Rupiah untuk Pendapatan
                                if (context.dataset.yAxisID === 'y') { 
                                    label += 'Rp' + context.parsed.y.toLocaleString('id-ID');
                                // Format Transaksi untuk Penjualan
                                } else { 
                                    label += context.parsed.y.toLocaleString('id-ID') + ' Transaksi';
                                }
                            }
                            return label;
                        }
                    }
                },
                legend: {
                    display: false 
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: { // Sumbu Kiri (Pendapatan)
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Pendapatan (Revenue)'
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            if (value >= 1000000) {
                                return 'Rp' + (value / 1000000).toLocaleString('id-ID') + 'JT';
                            } else if (value >= 1000) {
                                return 'Rp' + (value / 1000).toLocaleString('id-ID') + 'K';
                            } else {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                y1: { 
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false, 
                    },
                    title: {
                        display: true,
                        text: 'Penjualan (Transaksi)'
                    },
                    ticks: {
                        precision: 0 
                    }
                }
            }
        }
    });
</script>
@endsection