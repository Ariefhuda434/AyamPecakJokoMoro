@extends('layouts.app')

@section('title', 'Karyawan')

@section('content')

<div x-data="{ 
    isFormOpen: false,
    karyawanToEdit: null,
    isEdit: false, 
    
    openEditModal(employeeData) {
        this.karyawanToEdit = employeeData;
        this.isEdit = true;
        this.isFormOpen = true;
    },
    
    openCreateModal() {
        this.karyawanToEdit = null;
        this.isEdit = false;
        this.isFormOpen = true;
    },
    
    closeModal() {
        this.isFormOpen = false;
        setTimeout(() => {
            this.karyawanToEdit = null;
            this.isEdit = false;
        }, 300);
    }
}" 
class="h-screen w-screen relative">
    <div class="h-18 w-screen flex items-center">
        <p class="h-12 w-12 bg-primary ml-3 rounded-full"></p>
        <p class=""><span class="text-primary font-alata text-2xl ml-2">Karyawan</span></p>
        <span class="h-5 w-5 bg-secondary rounded-full ml-29"></span>
        <span class="h-9 rounded-full ml-5 w-[3px] bg-primary"></span>
        <span class="h-12 w-12 bg-white rounded-full border-2 border-text-bg-1 ml-5"></span>
    </div>
    
    <div class="h-18 w-full flex items-center justify-between">
        <p class="ml-10 font-alata">Karyawan({{ count($employees ) }})</p>
        <button @click="openCreateModal()" class="mr-10 bg-secondary p-2 text-white font-alata rounded-lg">Tambah Karyawan</button>
    </div>
    
    <div class="p-2">
        <div class="bg-white shadow-lg over rounded-lg p-4 overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Handphone</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th scope="col" class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
        
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($employees as $employee) 
                    <tr>
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $employee->name_employee }}</td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $employee->number_phone }}</td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $employee->role }}</td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($employee->date_join)->format('d-m-Y') }}</td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center items-center space-x-2">
                            
                            <button 
                                @click="openEditModal({{ json_encode($employee) }})" 
                                class="text-indigo-600 hover:text-indigo-900"
                                type="button"
                            >
                                Edit
                            </button>
                            <form action="{{ route('karyawan.destroy', $employee->Employee_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $employee->name_employee }}?');">
                                @csrf  
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            Data karyawan tidak tersedia.
                        </td> 
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div x-show="isFormOpen" @click="closeModal()" 
        class="fixed inset-0 bg-opacity-50 z-40"
        x-cloak style="display: none;">
    </div>
    <div x-show="isFormOpen" 
        x-transition:enter="ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full"
        class="h-3/4 bottom-0 rounded-tl-[5rem] flex justify-center p-4 w-full bg-background fixed z-50 overflow-y-auto"
        x-cloak style="display: none;">
        <button type="button" @click="closeModal()" class="absolute top-4 right-4 text-primary hover:text-red-600 z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <form 
            x-bind:action="isEdit 
                ? '{{ route('karyawan.update', ['employee' => 'Employee_id']) }}'.replace('Employee_id', karyawanToEdit.Employee_id)
                : '{{ route('karyawan.store') }}'" 
            method="POST" 
            class="w-full max-w-sm"
        >
            @csrf
            <template x-if="isEdit">
                @method('PUT')
            </template>
            <div class="flex flex-col items-center space-y-4 w-full"> 
                <p x-text="isEdit ? 'Ubah Data Karyawan' : 'Pendaftaran Karyawan'" 
                    class="text-4xl font-medium text-[#421512] mt-10 mb-6 font-neue">
                </p>
                <div class="w-full flex flex-col items-center relative">
                    <p class="mb-2 text-2sm ml-10 font-light text-primary w-4/5 text-left font-alata">Nama Karyawan</p>
                    <div class="relative w-4/5">
                        <input 
                            type="text" 
                            name="name_employee" 
                            placeholder="Masukan Nama Karyawan" 
                            class="w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out placeholder-gray-500 font-sans text-lg"
                            x-bind:value="karyawanToEdit ? karyawanToEdit.name_employee : ''"
                            required
                        />
                    </div>
                </div>
                <div class="w-full flex flex-col items-center relative">
                    <p class="mb-2 text-2sm ml-10 font-light text-primary w-4/5 text-left font-alata">Nomor Handphone</p>
                    <div class="relative w-4/5">
                        <input 
                            type="text" 
                            name="number_phone" 
                            placeholder="Masukan Nomor Handphone" 
                            class="w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out placeholder-gray-500 font-sans text-lg"
                            x-bind:value="karyawanToEdit ? karyawanToEdit.number_phone : ''"
                            required
                        />
                    </div>
                </div>
                <div class="w-full flex flex-col items-center relative">
                    <p class="mb-2 text-2sm ml-10 font-light text-primary w-4/5 text-left font-alata">Peran</p>
                    <div class="relative w-4/5">
                        <select name="role" class="w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out placeholder-gray-500 font-sans text-lg" required>
                            <option value="Cashier" x-bind:selected="karyawanToEdit && karyawanToEdit.role === 'Cashier'">Kasir</option> 
                            <option value="Waiter" x-bind:selected="karyawanToEdit && karyawanToEdit.role === 'Waiter'">Pelayan</option> 
                        </select>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center">
                    <p class="mb-2 text-2sm ml-10 text-primary font-light w-4/5 text-left font-alata" x-text="isEdit ? 'Ubah Kata Sandi (Opsional)' : 'Kata Sandi (Wajib)'">
                        Kata Sandi
                    </p>
                    <input 
                        type="password" name="password" 
                        placeholder="*******" 
                        class="w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out placeholder-gray-500 font-sans text-lg tranition ease-in-out duration-400" 
                        x-bind:required="!isEdit"
                        autocomplete="new-password"
                    />
                </div>
                <button 
                    type="submit" 
                    x-bind:class="isEdit ? 'bg-primary hover:bg-red-900' : 'bg-primary hover:bg-red-900'"
                    class="w-4/5 py-3 rounded-[10px] text-white mt-3 transition font-alata"
                    x-text="isEdit ? 'Simpan Perubahan' : 'Daftar'">
                    Daftar
                </button> 
            </div>
        </form>
    </div>
</div>

@endsection