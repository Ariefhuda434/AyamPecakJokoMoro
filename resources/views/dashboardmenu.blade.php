@extends('layouts.app')

@section('title', 'Manajemen Menu')

@section('content')

<div x-data="{ 
    isFormOpen: false,
    menuToEdit: null, 
    isEdit: false, 
    
    openEditModal(menuData) {
        this.menuToEdit = menuData;
        this.isEdit = true;
        this.isFormOpen = true;
    },
    
    openCreateModal() {
        this.menuToEdit = null;
        this.isEdit = false;
        this.isFormOpen = true;
    },
    
    closeModal() {
        this.isFormOpen = false;
        setTimeout(() => {
            this.menuToEdit = null;
            this.isEdit = false;
        }, 300);
    },

    getMenuId() {
        return this.menuToEdit ? this.menuToEdit.Menu_id : null;
    },
    
    goToRecipePage(menuId, menuSlug) {
        const url = '{{ route('recipies.index', ['menu' => '__menu_id__']) }}'.replace('__menu_id__', menuId);
        window.location.href = url;
    }
}" 
class="relative p-4"> 
    <div class="flex items-center justify-between mb-6 pt-2">
        <p class="text-xl font-alata font-semibold text-gray-700">
            Daftar Menu ({{ count($menuData ?? []) }}) 
        </p>
        <button @click="openCreateModal()" class="bg-secondary p-2 text-white font-alata rounded-lg transition hover:bg-secondary/90">
            + Tambah Menu Baru
        </button>
    </div>
    
    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Jual</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Resep</th> 
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan Resep </th> 
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> 
                    </tr>
                </thead>
        
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($menuData as $menu) 
                    
                    <tr class="hover:bg-blue-50 cursor-pointer" 
                        @click="goToRecipePage({{ $menu->Menu_id }}, '{{ Str::slug($menu->Name) }}')"> 
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if ($menu->Photo)
                                <img src="{{ asset('storage/' . $menu->Photo) }}" alt="{{ $menu->Name }}" class="h-10 w-10 rounded object-cover">
                            @else
                                -
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $menu->Name ?? '-'}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->Category ?? '-'}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($menu->Price ?? 0, 0, ',', '.') }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($menu->Menu_Status == 'Tersedia') bg-green-100 text-green-800
                                @elseif($menu->Menu_Status == 'Tidak Tersedia') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $menu->Menu_Status ?? 'N/A' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                            <span class="font-bold">{{ $menu->nama_resep}}</span>
                            
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->Keterangan ?? '-'}}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center items-center space-x-3" @click.stop>
                        
                            <button 
                                @click="openEditModal({{ json_encode($menu) }})" 
                                class="text-indigo-600 hover:text-indigo-900 transition"
                                type="button"
                            >
                                Edit
                            </button>
                            
                           
                            <form action="{{ route('menu.destroy', $menu->Menu_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ $menu->Name }}? Semua resep terkait akan hilang.');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            Belum ada data menu. Silakan tambahkan menu baru.
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
                    ? '{{ route('menu.update', ['menu' => '__menu_id__']) }}'.replace('__menu_id__', getMenuId())
                    : '{{ route('menu.store') }}'" 
                method="POST" 
                class="w-full"
            >
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                
                <div class="flex flex-col items-center space-y-4 w-full pb-10"> 
                    <p x-text="isEdit ? 'Ubah Data Menu ' + menuToEdit.Name : 'Penambahan Menu Baru'" 
                        class="text-2xl font-semibold text-primary mt-10 mb-6 font-alata text-center">
                    </p>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Nama Menu</p>
                        <input 
                            type="file" name="photo"
                            placeholder="photo" 
                            class="w-4/5 peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                placeholder-gray-500 font-sans text-lg"
                            accept="image/*"
                            x-bind:value="isEdit ? menuToEdit.photo : ''" 
                            required
                        />
                    </div>
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Nama Menu</p>
                        <input 
                            type="text" 
                            name="Name" 
                            placeholder="Masukan Nama Menu" 
                            class="w-4/5 peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                placeholder-gray-500 font-sans text-lg"
                            x-bind:value="isEdit ? menuToEdit.Name : ''" 
                            required
                        />
                    </div>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Harga Jual</p>
                        <input 
                            type="number" 
                            name="Price" 
                            placeholder="Contoh: 25000" 
                            class="w-4/5 peer border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                placeholder-gray-500 font-sans text-lg"
                            x-bind:value="isEdit ? menuToEdit.Price : ''" 
                            required
                        />
                    </div>

                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Kategori</p>
                        <div class="relative w-4/5">
                            <select 
                                name="Category" 
                                id="category" 
                                required
                                class="w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                        py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                        placeholder-gray-500 font-sans text-lg appearance-none" 
                            >
                                <option value="" disabled x-bind:selected="!isEdit">Pilih Kategori</option>
                                <option value="Makanan" x-bind:selected="isEdit && menuToEdit.Category === 'Makanan'">Makanan</option>
                                <option value="Minuman" x-bind:selected="isEdit && menuToEdit.Category === 'Minuman'">Minuman</option>
                                <option value="Cemilan" x-bind:selected="isEdit && menuToEdit.Category === 'Cemilan'">Cemilan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Status Penjualan</p>
                        <div class="relative w-4/5">
                            <select 
                                name="Menu_Status" 
                                id="menu_status" 
                                required
                                class="w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                                        py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                                        placeholder-gray-500 font-sans text-lg appearance-none" 
                            >
                                <option value="Tersedia" x-bind:selected="isEdit && menuToEdit.Menu_Status === 'Tersedia'">Tersedia (Dijual)</option>
                                <option value="Tidak Tersedia" x-bind:selected="isEdit && menuToEdit.Menu_Status === 'Tidak Tersedia'">Tidak Tersedia (Habis/Tidak Dijual)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="bg-primary w-4/5 py-3 rounded-[10px] text-white mt-3 hover:bg-red-900 transition font-alata"
                        x-text="isEdit ? 'Simpan Perubahan Menu' : 'Tambahkan Menu Baru'">
                    </button> 
                </div>
            </form>
        </div>
    </div>
</div>

@endsection