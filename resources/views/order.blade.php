@extends('layouts.app')

@section('title', 'order')

@section('content')

    <div class="h-screen w-screen">
        {{-- bagian atas ni --}}
        <div class="h-18 w-screen flex items-center">
            <p class="h-12 w-12 bg-primary ml-3 rounded-full"></p>
            <p class=""><span class="text-primary font-alata text-2xl ml-2">Pemesanan</span></p>
            <span class="h-5 w-5 bg-secondary rounded-full ml-29"></span>
            <span class="h-9 rounded-full ml-5 w-[3px] bg-primary"></span>
            <span class="h-12 w-12 bg-white rounded-full border-2 border-text-bg-1 ml-5"></span>
        </div>
        {{-- bagian filter --}}
        <div class="h-20 w-screen flex items-center justify-center gap-4">
            <div class="h-20 w-48 items-center flex bg-secondary rounded-[1rem]">
                <p class="h-13 w-13 ml-4 bg-white"></p>
                <div class="ml-3">
                    <p class="text-background font-alata text-lg flex">Semua
                        <span class="ml-1 h-5 w-5 bg-black"></span>
                    </p>
                    <p class="flex">115 items</p>
                </div>
            </div>
            <div class="h-20 w-48 items-center flex bg-primary  rounded-[1rem]">
                <p class="h-13 w-13 ml-4 bg-white"></p>
                <div class="ml-3">
                    <p class="text-background font-alata text-lg flex">Status
                        <span class="ml-1 h-5 w-5 bg-background"></span>
                    </p>
                    <p class="flex text-background">Kosong</p>
                </div>
            </div>
        </div>
        {{-- bagian isi --}}
<div class="w-screen h-full flex justify-center flex-col  mt-4 gap-4">
<div class="flex w-screen justify-center gap-4">
            <div class="h-63 w-48 bg-white border-4 border-primary rounded-[1rem]">
                <div class="flex justify-between">
                    <p class="font-alata text-primary text-xl ml-6 mt-4">Meja 1</p>
                        <p class="mt-[1.4rem] mr-[1.3rem] text-sm px-3 bg-green-100 rounded-[0.5rem]"></span>Status</p>
                </div>
                <div class="w-full h-11 mt-3 flex justify-center">
                    <input type="text" name="nama" placeholder="Nama" value="{{ old('nama_pelanggan') }}"
                        class=" w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                    px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" />
                </div>
                <div class="w-full h-11 flex justify-center mt-3">
                    <input type="text" name="nomor_hp" placeholder="Nomor HP" value="{{ old('Nomor_Hp') }}"
                        class="w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                    px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" />
                </div>

                <div class="w-full h-14 flex items-center flex-col justify-center mt-3">
                    <button type="submit" class="bg-primary  text-background h-10 w-4/5 rounded-[0.5rem]">Bayar</button>
                    <a href="" class="underline text-[10px] mt-1">Batalkan Pesanan</a>
                </div>

            </div>
            <div class="h-63 w-48 bg-white border-4 border-primary rounded-[1rem]">
                <p class="font-alata text-primary text-xl ml-6 mt-4">Meja 1</p>
                <div class="w-full h-11 mt-3 flex justify-center">
                    <input type="text" name="nama" placeholder="Nama" value="{{ old('nama_pelanggan') }}"
                        class=" w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                    px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" />
                </div>
                <div class="w-full h-11 flex justify-center mt-3">
                    <input type="text" name="nomor_hp" placeholder="Nomor HP" value="{{ old('Nomor_Hp') }}"
                        class="w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                    px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" />
                </div>

                <div class="w-full h-14 flex items-center flex-col justify-center mt-3">
                    <button type="submit" class="bg-primary  text-background h-10 w-4/5 rounded-[0.5rem]">Bayar</button>
                    <a href="" class="underline text-[10px] mt-1">Batalkan Pesanan</a>
                </div>
            </div>
</div>

            <form action="{{ route('make.table') }}" method="POST" class="">
                @csrf
                <select name="number_table" id="">
                    @for ($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <button class="w-3/4 h-20">Tambah</button>
            </form>
    </div>

@endsection
