@extends('layouts.app')

@section('title', 'Stock')

@section('content')
<div class="flex h-screen w-screen bg-background overflow-hidden" x-data="{ showAddModal: false, showConfirmModal: false }">
  
    {{-- Main Content --}}
    <main class="flex-1 ml-24 lg:ml-64 p-8 overflow-y-auto h-full">
        {{-- Header --}}
       

        {{-- Sub Header --}}
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-primary font-alata">Stock (81)</h3>
            <button @click="showAddModal = true" class="bg-secondary text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-yellow-600 transition font-alata">
                Tambah Stock
            </button>
        </div>

        {{-- Table --}}
        <div class="rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-primary font-bold font-alata">
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Jumlah</th>
                        <th class="py-3 px-4">Unit</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-primary font-medium font-alata">
                    {{-- Loop 10 times for demo --}}
                    @for ($i = 0; $i < 10; $i++)
                    <tr class="{{ $i % 2 == 0 ? 'bg-[#D6D0C2]' : 'bg-[#EBE3D0]' }} hover:bg-opacity-80 transition border-none">
                        <td class="py-4 px-4">#101</td>
                        <td class="py-4 px-4">Ayam</td>
                        <td class="py-4 px-4">20</td>
                        <td class="py-4 px-4">Potong</td>
                        <td class="py-4 px-4 flex gap-3">
                            <button class="text-white hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                                  <path d="M21.731 2.269a2.625 2.625 0 1 1 3.71 3.71l-9.373 9.373-3.882 1.058 1.058-3.882 9.373-9.373Zm-2.269 2.269L12.462 11.538l-.613 2.247 2.247-.613 6.99-6.99-1.625-1.625Z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                  <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </main>

    {{-- Add Stock Modal (Right Side Panel) --}}
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex justify-end" style="display: none;">
        <div @click="showAddModal = false" class="absolute inset-0 bg-black/50 transition-opacity" x-transition.opacity></div>
        
        {{-- Panel --}}
        <div class="relative w-full max-w-md bg-background h-full shadow-2xl p-8 flex flex-col border-l-4 border-primary rounded-l-[3rem]" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-primary font-neue tracking-wide uppercase">Penambahan Stok</h2>
                <button @click="showAddModal = false" class="bg-primary text-white rounded-full p-1 hover:bg-opacity-80">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-primary font-bold text-xl mb-2 font-alata">Nama Stok</label>
                    <input type="text" placeholder="Masukan nama stok" class="w-full bg-transparent border-2 border-primary rounded-lg px-4 py-3 text-primary placeholder-primary/50 focus:outline-none focus:ring-2 focus:ring-secondary font-alata">
                </div>
            </div>

            <div class="mt-auto">
                <button @click="showAddModal = false; showConfirmModal = true" class="w-full bg-primary text-white font-bold py-4 rounded-lg hover:bg-opacity-90 transition font-alata text-lg">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div x-show="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div class="absolute inset-0 bg-black/50" @click="showConfirmModal = false"></div>
        <div class="relative bg-background border-2 border-primary rounded-xl p-8 max-w-sm w-full text-center shadow-xl transform transition-all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <h3 class="text-2xl font-bold text-primary font-neue mb-4 uppercase tracking-wide">Konfirmasi Stock</h3>
            <p class="text-primary font-alata mb-8">Tekan Lanjutkan untuk memproses Stock, atau Batal untuk kembali</p>
            <div class="flex gap-4">
                <button @click="showConfirmModal = false" class="flex-1 bg-primary text-white py-2 rounded-lg font-bold hover:bg-opacity-90 transition font-alata">Lanjut</button>
                <button @click="showConfirmModal = false" class="flex-1 bg-primary text-white py-2 rounded-lg font-bold hover:bg-opacity-90 transition font-alata">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection