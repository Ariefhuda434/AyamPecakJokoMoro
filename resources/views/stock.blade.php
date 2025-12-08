@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')

<div x-data="{ 
    isFormOpen: false,
    stockToEdit: null, 
    isEdit: false, 
    
    openEditModal(stockData) {
        this.stockToEdit = stockData;
        this.isEdit = true;
        this.isFormOpen = true;
    },
    
    openCreateModal() {
        this.stockToEdit = null;
        this.isEdit = false;
        this.isFormOpen = true;
    },
    
    closeModal() {
        this.isFormOpen = false;
        setTimeout(() => {
            this.stockToEdit = null;
            this.isEdit = false;
        }, 300);
    },

    getStockId() {
        return this.stockToEdit ? this.stockToEdit.Stock_id : null;
    },
    
    submitRestockForm(stockId) {
        document.getElementById('restock-form-' + stockId).submit();
    }
}" 
class="relative p-4"> 
    <div class="flex items-center justify-between mb-6 pt-2">
        <p class="text-xl font-alata font-semibold text-gray-700">
            Daftar Stok ({{ count($stockData ?? []) }}) 
        </p>
        <button @click="openCreateModal()" class="bg-secondary p-2 text-white font-alata rounded-lg transition hover:bg-secondary/90">
            + Tambah Stok
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Terkini</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Level</th> 
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Restock Terakhir</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Restock</th> 
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Restok Terakhir</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
        
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($stockData as $stock) 
                    
                    <tr class="hover:bg-gray-50 cursor-pointer" @click="submitRestockForm({{ $stock->Stock_id }})"> 
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            
                            <form 
                                method="GET" 
                                action="{{ route('restock.index', ['slug' => Str::slug($stock->nama_stock)]) }}" 
                                id="restock-form-{{ $stock->Stock_id }}" 
                                class="hidden" 
                            >
                            <input type="hidden" name="stock_id" value="{{ $stock->Stock_id }}">
                            </form>
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $stock->nama_stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $stock->unit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $stock->jumlah_terkini ?? 0}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $stock->jumlah_minimum }}</td> 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp{{ number_format($stock->harga_restock_terakhir ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $stock->total_restock_count ?? 0 }}x</td> 
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                            {{ $stock->tanggal_restock_terakhir ? \Carbon\Carbon::parse($stock->tanggal_restock_terakhir)->format('d-m-Y') : '-' }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center items-center space-x-3" @click.stop>
                        
                            <button 
                                @click="openEditModal({{ json_encode($stock) }})" 
                                class="text-indigo-600 hover:text-indigo-900 transition"
                                type="button"
                            >
                                Edit
                            </button>
                            
                            <form action="{{ route('stock.destroy', $stock->Stock_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $stock->nama_stock }}?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            Data stok tidak tersedia.
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
                x-bind:action="isEdit 
                    ? '{{ route('stock.update', ['stock' => '__stock_id__']) }}'.replace('__stock_id__', getStockId())
                    : '{{ route('stock.store') }}'" 
                method="POST" 
                class="w-full"
            >
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                
                <div class="flex flex-col items-center space-y-4 w-full pb-10"> 
                    <p x-text="isEdit ? 'Ubah Data Stok ' + stockToEdit.nama_stock : 'Penambahan Stock Baru'" 
                        class="text-2xl font-semibold text-primary mt-10 mb-6 font-alata text-center">
                    </p>
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Nama Stok</p>
                        <input 
                            type="text" 
                            name="Name_Stock" 
                            placeholder="Masukan Nama Stok" 
                            class="w-4/5 peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg"
                            x-bind:value="isEdit ? stockToEdit.nama_stock : ''" 
                            required
                        />
                    </div>
                    
                   <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Jenis Satuan</p>
                        
                        <div class="relative w-4/5">
                            <select 
                                name="Unit" 
                                id="unit" 
                                required
                                class="w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                            py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                            placeholder-gray-500 font-sans text-lg appearance-none" 
                            >
                                <option value="" disabled x-bind:selected="!isEdit">Pilih Satuan</option>
                                <option value="Kilogram" x-bind:selected="isEdit && stockToEdit.Unit === 'Kilogram'">Kilogram (kg)</option>
                                <option value="Gram" x-bind:selected="isEdit && stockToEdit.Unit === 'Gram'">Gram (gr)</option>
                                <option value="Pcs" x-bind:selected="isEdit && stockToEdit.Unit === 'Pcs'">Pcs (Satuan)</option>
                                <option value="Potong" x-bind:selected="isEdit && stockToEdit.Unit === 'Potong'">Potong</option>
                                <option value="Liter" x-bind:selected="isEdit && stockToEdit.Unit === 'Liter'">Liter</option>
                                <option value="Botol" x-bind:selected="isEdit && stockToEdit.Unit === 'Botol'">Botol</option>
                                <option value="Kotak" x-bind:selected="isEdit && stockToEdit.Unit === 'Kotak'">Kotak</option>
                                
                            </select>
                            
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                        
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Level Stok Minimum (pcs/unit)</p>
                        <input 
                            type="number" 
                            name="Min_Stock_Level" 
                            placeholder="Contoh: 10"
                            class="w-4/5 peer  border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg"
                            x-bind:value="isEdit ? stockToEdit.jumlah_minimum : ''" 
                            required
                        />
                    </div>

                    
                    <button 
                        type="submit" 
                        class="bg-primary w-4/5 py-3 rounded-[10px] text-background mt-3 hover:bg-red-900 transition font-alata"
                        x-text="isEdit ? 'Simpan Perubahan' : 'Tambahkan Stok'">
                    </button> 
                </div>
            </form>
        </div>
    </div>
</div>

@endsection