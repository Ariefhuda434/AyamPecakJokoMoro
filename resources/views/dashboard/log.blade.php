@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')


<div class="p-6 bg-gray-50 min-h-screen"> 
    <a href="{{ route('dashboard.view') }}" class="mr-3 text-primary hover:text-secondary transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
    <h1 class="text-3xl font-alata font-bold text-gray-800 mb-6 border-b pb-2">
        Riwayat Log Aktivitas Sistem (Total: {{ $logData->total() }})
    </h1>

    <div class="bg-white shadow-xl rounded-xl p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Penyaring Data</h2>
        <form action="{{ route('log.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label for="action_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Aksi</label>
                <select name="action_type" id="action_type" 
                        class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                    <option value="all">Semua Aksi</option>
                    @php $currentAction = request('action_type'); @endphp
                    <option value="CREATE" {{ $currentAction == 'CREATE' ? 'selected' : '' }}>CREATE (Tambah)</option>
                    <option value="UPDATE" {{ $currentAction == 'UPDATE' ? 'selected' : '' }}>UPDATE (Ubah)</option>
                    <option value="DELETE" {{ $currentAction == 'DELETE' ? 'selected' : '' }}>DELETE (Hapus)</option>
                </select>
            </div>
            
            <div>
                <label for="table_name" class="block text-sm font-medium text-gray-700 mb-1">Filter Tabel</label>
                <select name="table_name" id="table_name" 
                        class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                    <option value="all">Semua Tabel</option>
                    @php $currentTable = request('table_name'); @endphp
                    @foreach ($availableTables as $table)
                        <option value="{{ $table }}" {{ $currentTable == $table ? 'selected' : '' }}>{{ strtoupper($table) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-primary text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition shadow-md">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu Aktivitas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tabel & Record ID</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Detail Perubahan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Oleh Karyawan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($logData as $log)
                    <tr class="hover:bg-gray-50 transition duration-150"> 
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $logData->firstItem() + $loop->index }} 
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-700">
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($log->Change_time)->format('d F Y') }}</span>
                            <br>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($log->Change_time)->format('H:i:s') }} WIB</span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ strtoupper($log->Table_Name) }} <p class="text-xs text-gray-500">(ID: {{ $log->Record_ID }})</p>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                            @php
                                $color = '';
                                if ($log->Action_Typn == 'CREATE') $color = 'text-green-800 bg-green-200';
                                elseif ($log->Action_Typn == 'UPDATE') $color = 'text-blue-800 bg-blue-200';
                                elseif ($log->Action_Typn == 'DELETE') $color = 'text-red-800 bg-red-200';
                                else $color = 'text-gray-800 bg-gray-200';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $log->Action_Typn }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-lg">
                            <p class="font-medium">Kolom: {{ $log->Column_Name }}</p>
                            
                            @php
                                $oldValue = $log->Old_Value ?? 'NULL';
                                $newValue = $log->New_Value ?? 'NULL';
                            @endphp

                            @if ($log->Action_Typn == 'UPDATE')
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="text-red-500">Dari: {{ Str::limit($oldValue, 40) }}</span> 
                                    &rarr; 
                                    <span class="text-green-600">Ke: {{ Str::limit($newValue, 40) }}</span>
                                </p>
                            @elseif ($log->Action_Typn == 'CREATE')
                                <p class="text-xs text-green-600 mt-1">Nilai Baru: {{ Str::limit($newValue, 80) }}</p>
                            @elseif ($log->Action_Typn == 'DELETE')
                                <p class="text-xs text-red-600 mt-1">Data Dihapus (Nilai Lama: {{ Str::limit($oldValue, 80) }})</p>
                            @endif

                            @if (strlen($oldValue) > 40 || strlen($newValue) > 40)
                                <p class="mt-1">
                                    <button onclick="alert('Nilai Lama: {{ $oldValue }} \n\nNilai Baru: {{ $newValue }}')" class="text-blue-500 hover:underline text-xs font-semibold">Lihat Detail Nilai</button>
                                </p>
                            @endif

                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ $log->employee_name ?? 'N/A' }}
                            <p class="text-xs text-gray-500">({{ $log->Employee_id }})</p>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 whitespace-nowrap text-center text-lg font-medium text-gray-500">
                            <i class="fas fa-search-minus mr-2"></i> Tidak ada riwayat aktivitas yang tercatat dengan filter yang berlaku.
                        </td> 
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> 

    <div class="mt-6">
        {{ $logData->links() }}
    </div>
</div>
@endsection