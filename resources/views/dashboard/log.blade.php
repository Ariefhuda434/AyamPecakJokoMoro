@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')

<div class="relative p-4"> 
    <div class="flex items-center justify-between mb-6 pt-2">
        <p class="text-2xl font-alata font-bold text-gray-800 border-b pb-2">
            Riwayat Log Aktivitas ({{ count($logData ?? []) }}) 
        </p>
        {{-- Tombol Tambahan, mungkin untuk Filter atau Export --}}
        <div class="flex items-center space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition">Filter</button>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tabel</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Aksi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Perubahan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh Karyawan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logData as $log)
                    <tr class="hover:bg-gray-50"> 
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-700">
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($log->Change_time)->format('d-m-Y') }}</span>
                            <br>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($log->Change_time)->format('H:i:s') }}</span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ strtoupper($log->Table_Name) }} (ID: {{ $log->Record_ID }})
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                            @php
                                $color = '';
                                if ($log->Action_Typn == 'CREATE') $color = 'text-green-600 bg-green-100';
                                elseif ($log->Action_Typn == 'UPDATE') $color = 'text-yellow-600 bg-yellow-100';
                                elseif ($log->Action_Typn == 'DELETE') $color = 'text-red-600 bg-red-100';
                                else $color = 'text-gray-600 bg-gray-100';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs {{ $color }}">
                                {{ $log->Action_Typn }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-sm">
                            <p class="font-medium">Kolom: **{{ $log->Column_Name }}**</p>
                            @if ($log->Action_Typn == 'UPDATE')
                                <p class="text-xs text-gray-500">
                                    <span class="text-red-500">Dari: {{ $log->Old_Value ?? '-' }}</span> 
                                    &rarr; 
                                    <span class="text-green-600">Ke: {{ $log->New_Value ?? '-' }}</span>
                                </p>
                            @elseif ($log->Action_Typn == 'CREATE')
                                <p class="text-xs text-green-600">Nilai Baru: {{ $log->New_Value ?? '-' }}</p>
                            @elseif ($log->Action_Typn == 'DELETE')
                                <p class="text-xs text-red-600">Data Dihapus (Nilai Lama: {{ $log->Old_Value ?? '-' }})</p>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            **{{ $log->employee_name ?? 'N/A' }}**
                            <p class="text-xs text-gray-500">({{ $log->Employee_id }})</p>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            Belum ada riwayat aktivitas yang tercatat.
                        </td> 
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>   
</div>

@endsection