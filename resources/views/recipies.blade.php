@extends('layouts.app')

@section('title', 'Resep: ' . $menu->Name) 

@section('content')

<div x-data="{ 
    isBahanFormOpen: false,
    openBahanModal() { this.isBahanFormOpen = true; },
    closeBahanModal() { this.isBahanFormOpen = false; },
}" 
class="relative p-4"> 
    
    @if (session('success'))
        {{-- Tampilkan notifikasi sukses --}}
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if ($errors->any())
        {{-- Tampilkan error validasi --}}
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">Ada masalah dengan input Anda.</span>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6 pt-2">
        <p class="text-xl font-alata font-semibold text-gray-700 flex items-center">
            <a href="{{ route('menu.index') }}" class="mr-3 text-primary hover:text-secondary transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            Detail Resep: {{ $menu->Name }}
        </p>
        
        <button @click="openBahanModal()" class="bg-indigo-600 p-2 text-white font-alata rounded-lg transition hover:bg-indigo-700">
            + Tambah/Kelola Bahan
        </button>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 md:flex md:space-x-6">
        
        <div class="md:w-1/3 mb-6 md:mb-0">
            <h3 class="text-lg font-alata font-semibold mb-4 border-b pb-2 text-gray-700">Info Dasar Menu</h3>
            
            @if ($menu->foto_menu) 
                <img src="{{ asset('storage/' . $menu->foto_menu) }}" alt="{{ $menu->Name }}" 
                    class="w-full h-48 object-cover rounded-lg shadow-md mb-4 border border-gray-200">
            @else
                <div class="w-full h-48 flex items-center justify-center bg-gray-100 rounded-lg mb-4 text-gray-500">
                    No Image
                </div>
            @endif

            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="font-semibold text-gray-600">Harga Jual:</span> 
                    <span class="font-bold text-gray-800">Rp {{ number_format($menu->Price ?? 0, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="font-semibold text-gray-600">Kategori:</span> 
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $menu->Category ?? '-'}}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-600">Status Jual:</span> 
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $menu->Menu_Status == 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $menu->Menu_Status ?? '-'}}
                    </span>
                </div>
            </div>
        </div>

        <div class="md:w-2/3">
            <h3 class="text-lg font-alata font-semibold mb-3 border-b pb-2 text-primary">Detail Resep</h3>

            {{-- HEADER RESEP (NAMA & KETERANGAN) --}}
            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300">
                <p class="text-sm font-alata text-gray-500 mb-1">Nama Resep:</p>
                <p class="text-lg font-semibold text-gray-800 mb-4">
                    {{ $resepData->isNotEmpty() ? $resepData->first()->nama_resep : 'Belum ada Nama Resep' }}
                </p>

                <p class="text-sm font-alata text-gray-500 mb-1">Keterangan Resep:</p>
                <p class="text-base text-gray-700 italic">
                    {{ $resepData->isNotEmpty() ? $resepData->first()->keterangan_resep : 'Tidak ada keterangan resep.' }}
                </p>
            </div>

            <h3 class="text-lg font-alata font-semibold mb-3 border-b pb-2 text-secondary">Daftar Bahan</h3>
            
            {{-- TABEL BAHAN --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Bahan</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kuantitas</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($resepData as $resep) 
                        <tr x-data="{ qty: {{ $resep->jumlah_stock_resep }} }" class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $resep->nama_stock_resep }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                {{-- Kuantitas bahan saat ini (contoh: 1.5) --}}
                                <span class="font-bold text-gray-800" x-text="qty">{{ $resep->jumlah_stock_resep }}</span>
                                
                                {{-- Jika Anda ingin mengedit kuantitas di sini, gunakan form yang terpisah --}}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                {{ $resep->Satuan_resep }}
                            </td>                           
                            <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                                <button class="text-red-600 hover:text-red-900 transition text-xs">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 whitespace-nowrap text-center text-sm text-gray-500 italic">
                                Belum ada bahan yang terdaftar untuk resep ini.
                            </td> 
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    {{-- MODAL FORM TAMBAH BAHAN --}}
    <div x-show="isBahanFormOpen" @click="closeBahanModal()" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" x-cloak style="display: none;"></div>

    <div x-show="isBahanFormOpen" x-transition class="h-3/4 bottom-0 rounded-tl-3xl rounded-tr-3xl border-t-5 border-l-5 border-primary flex justify-center p-4 w-full bg-background fixed z-50 overflow-y-auto shadow-2xl" x-cloak style="display: none;">
        <div class="w-full max-w-md relative">
                <form action="{{ route('recipies.store', ['slug' => $menu->slug]) }}" method="POST" class="w-full">
                @csrf
                <div class="flex flex-col items-center space-y-4 w-full pb-10"> 
                    <p class="text-2xl font-semibold text-primary mt-10 mb-6 font-alata text-center">
                        Tambahkan Bahan untuk **{{ $menu->Name }}**
                    </p>
                    
                    <input type="hidden" name="Recipe_id" value="{{ $menu->Recipe_id }}">

                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Nama Bahan</p>
                        <select name="Stock_id" id="Stock_id_select"
                                class="w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out font-sans text-lg"
                                required
                        >
                            <option value="" disabled selected>Pilih Bahan Baku</option>
                            @forelse ($stockData as $stock)
                            <option value="{{ $stock->Stock_id }}" data-unit="{{ $stock->satuan_resep }}">
                                {{ $stock->nama_stock_resep }}
                            </option>
                            @empty
                            <option disabled>Tidak ada stok bahan tersedia</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Kuantitas Bahan</p>
                        <div class="w-4/5 relative">
                            <input 
                                type="number" 
                                name="Quantity" 
                                placeholder="Masukkan Jumlah" 
                                min="0"
                                step="any"
                                class="w-full peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                        py-3 px-6 pr-24 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                        placeholder-gray-500 font-sans text-lg"
                                required
                            />
                            <span id="unit_display" class="absolute right-0 top-0 h-full flex items-center pr-4 text-gray-600 font-semibold pointer-events-none text-sm">
                                Satuan
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-primary w-4/5 py-3 rounded-[10px] text-white mt-3 font-alata hover:bg-indigo-700 transition">Tambahkan</button> 
                </div>
            </form>
            
            {{-- SCRIPT JAVASCRIPT UNTUK MEMPERBARUI SATUAN BAHAN --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const selectElement = document.getElementById('Stock_id_select');
                    const unitDisplay = document.getElementById('unit_display');

                    function updateUnitDisplay() {
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        // Ambil nilai dari atribut data-unit yang kita set di <option>
                        const unit = selectedOption.getAttribute('data-unit');
                        unitDisplay.textContent = unit || 'Satuan';
                    }

                    // Panggil saat halaman pertama kali dimuat
                    updateUnitDisplay();

                    // Panggil setiap kali pilihan di dropdown berubah
                    selectElement.addEventListener('change', updateUnitDisplay);
                });
            </script>
        </div>
    </div>
</div>
@endsection