@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

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
class=" relative p-4"> 
    
    <div class="flex items-center justify-between mb-6 pt-2">
        <p class="text-xl font-alata font-semibold text-gray-700">
            Daftar Karyawan ({{ count($employeeData ?? []) }}) 
        </p>
        <button @click="openCreateModal()" class="bg-secondary p-2 text-white font-alata rounded-lg transition hover:bg-secondary/90">
            + Tambah Karyawan
        </button>
    </div>
    
    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Handphone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran (Role)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
        
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($employeeData as $employee) 
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->Nama_karyawan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->Nomor_handphone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->Role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($employee->Tanggal_Bergabung)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center items-center space-x-3">
                            
                            <button 
                                @click="openEditModal({{ json_encode($employee) }})" 
                                class="text-indigo-600 hover:text-indigo-900 transition"
                                type="button"
                            >
                                Edit
                            </button>
                            
                            <form action="{{ route('employee.destroy', $employee->Id_manajer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $employee->Nama_manajer }}?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 whitespace-nowrap text-center text-sm font-medium text-gray-500">
                            Data karyawan tidak tersedia.
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
        class="h-3/4 bottom-0 rounded-tl-3xl rounded-tr-3xl border-t-8 border-l-8 border-primary flex justify-center p-4 w-full bg-background fixed z-50 overflow-y-auto shadow-2xl"
        x-cloak style="display: none;">
        
        <div class="w-full max-w-md relative">
          
            <form 
                x-bind:action="isEdit 
                    ? '{{ route('employee.update', ['employee' => '__Employee_id__']) }}'.replace('__Employee_id__', karyawanToEdit.Id_manajer)
                    : '{{ route('employee.store') }}'" 
                method="POST" 
                class="w-full"
            >
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                
                <div class="flex flex-col items-center space-y-4 w-full pb-10"> 
                    <p x-text="isEdit ? 'Ubah Data Karyawan' : 'Pendaftaran Karyawan'" 
                        class="text-2xl font-semibold text-primary mt-10 mb-6 font-alata text-center">
                    </p>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Nama Karyawan</p>
                        <input 
                            type="text" 
                            name="name_employee" 
                            placeholder="Masukan Nama Karyawan" 
                            class="w-4/5 peer  border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg"
                            x-bind:value="karyawanToEdit ? karyawanToEdit.Nama_manajer : ''"
                            required
                        />
                    </div>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Nomor Handphone</p>
                        <input 
                            type="text" 
                            name="number_phone" 
                            placeholder="Masukan Nomor Handphone" 
                            class="w-4/5 peer  border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg"
                            x-bind:value="karyawanToEdit ? karyawanToEdit.Nomor_handphone : ''"
                            required
                        />
                    </div>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata">Peran</p>
                        <select name="role_id" class="w-4/5 peer  border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" required>
                            <option value="" disabled x-bind:selected="!karyawanToEdit || !karyawanToEdit.role">Pilih Peran</option>
                            <option value="1" x-bind:selected="karyawanToEdit && karyawanToEdit.role === '1'">Manager</option> 
                            <option value="2" x-bind:selected="karyawanToEdit && karyawanToEdit.role === '2'">Kasir</option> 
                            <option value="3" x-bind:selected="karyawanToEdit && karyawanToEdit.role === '3'">Pelayan</option> 
                        </select>
                    </div>
                    
                    <div class="w-full flex flex-col items-center">
                        <p class="mb-2 text-sm font-medium text-gray-700 w-4/5 text-left font-alata" 
                           x-text="isEdit ? 'Ubah Kata Sandi (Kosongkan jika tidak diubah)' : 'Kata Sandi (Wajib)'">
                        </p>
                        <input 
                            type="password" name="password" 
                            placeholder="******" 
                            class="w-4/5 peer  border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" 
                            x-bind:required="!isEdit"
                            autocomplete="new-password"
                        />
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-4/5 py-3 rounded-lg text-white mt-8 transition font-alata bg-primary hover:bg-red-900"
                        x-text="isEdit ? 'Simpan Perubahan' : 'Daftar Karyawan'">
                    </button> 
                </div>
            </form>
        </div>
    </div>
</div>

@endsection