@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')

<div x-data="{ 
    isFormOpen: false,
    
    openCreateModal() {
        this.isFormOpen = true;
    },
    
    closeModal() {
        this.isFormOpen = false;
    }
}" 
class="relative p-4"> 
    
    <div class="flex items-center justify-between mb-6 pt-2">
        <p class="text-xl font-alata font-semibold text-gray-700">
            Daftar Log Restok: {{ $stock->Name_Stock ?? 'Produk Tidak Dikenal' }} ({{ count($restockData ?? []) }}) 
        </p>
        <button @click="openCreateModal()" class="bg-secondary p-2 text-white font-alata rounded-lg transition hover:bg-secondary/90">
            + Tambah Restok
        </button>
    </div>
    
    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Sebelum</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Ditambah</th> 
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Setelah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya Total</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Restok</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Update</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($restockData as $restock) 
                    
                    <tr class="hover:bg-gray-50 cursor-pointer" >
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $restock->nama_stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $restock->unit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $restock->jumlah_sebelum ?? 0}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $restock->jumlah_ditambahkan ?? 0}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $restock->jumlah_setelah }}</td> 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp{{ number_format(($restock->jumlah_ditambahkan * ($restock->harga_restock ?? 0)) ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $restock->tanggal_restock ? \Carbon\Carbon::parse($restock->tanggal_restock)->format('d-m-Y') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $restock->tanggal_restock_update ? \Carbon\Carbon::parse($restock->tanggal_restock_update)->format('d-m-Y') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center items-center space-x-3" @click.stop>
                            
                            <button 
                                @click="openEditModal({{ json_encode($restock) }})" 
                                class="text-indigo-600 hover:text-indigo-900 transition"
                                type="button"
                                style="display: none;" 
                            >
                                Edit
                            </button>
                            
                            <form action="{{ route('restock.destroy', ['restockLog' => $restock->Stock_id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log restok ini?');">
                                @csrf 
                                @method('DELETE')       
                                <button type="submit" class="text-red-600 hover:text-red-900 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-10 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            Belum ada log restok untuk stok {{ $stock->Name_Stock }}.
                        </td> 
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div x-show="isFormOpen" @click="closeModal()" 
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
        x-cloak style="display: none;">
    </div>

    <div x-show="isFormOpen" 
        x-transition:enter="ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full"
        class="h-3/4 bottom-0 rounded-tl-3xl rounded-tr-3xl border-t-5 border-l-5 border-primary flex justify-center p-4 w-full bg-background fixed z-50 overflow-y-auto shadow-2xl" 
        x-cloak style="display: none;">
        
        <div class="w-full max-w-md relative">
            
            <form 
                action="{{ route('restock.store') }}" 
                method="POST" 
                class="w-full"
            >
                @csrf
                
                <input type="hidden" name="Stock_id" value="{{ $stock->Stock_id }}">
                <input type="hidden" name="Stock_Before" value="{{ $stock->Current_Quantity ?? 0 }}">
                <input type="hidden" name="Unit" value="{{ $stock->Unit }}">
                
                <div class="flex flex-col items-center space-y-4 w-full pb-10"> 
                    <p class="text-2xl font-semibold text-primary mt-10 mb-6 font-alata text-center">
                        Tambah Restok untuk {{ $stock->Name_Stock }}
                    </p>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Jumlah Unit Ditambahkan ({{ $stock->Unit }})</p>
                        <input 
                            type="number" 
                            name="Update_Quantity" 
                            placeholder="Contoh: 50" 
                            class="w-4/5 peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out placeholder-gray-500 font-sans text-lg"
                            required
                        />
                    </div>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Harga Restok per Unit (Rp)</p>
                        <input 
                            type="number" 
                            name="Price" 
                            placeholder="Contoh: 15000"
                            class="w-4/5 peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out placeholder-gray-500 font-sans text-lg"
                            required
                        />
                    </div>

                    
                    <button 
                        type="submit" 
                        class="bg-primary w-4/5 py-3 rounded-[10px] text-background mt-3 hover:bg-red-900 transition font-alata"
                    >
                        Simpan Log Restok
                    </button> 
                </div>
            </form>
        </div>
    </div>
</div>

@endsection