@extends('layouts.app')

@section('title','menu')

@section('content')

<div class="h-full w-screen">
        <div class="h-18 w-screen flex items-center">
            <p class="h-12 w-12 bg-primary ml-3 rounded-full"></p>
            <p class=""><span class="text-primary font-alata text-2xl ml-2">Menu</span></p>
            <span class="h-5 w-5 bg-secondary rounded-full ml-43"></span>
            <span class="h-9 rounded-full ml-5 w-[3px] bg-primary"></span>
            <span class="h-12 w-12 bg-white rounded-full border-2 border-text-bg-1 ml-5"></span>
        </div>
        <div class="w-screen flex mt-2 justify-center gap-3 h-40 overflow-scroll">
            <div class="h-32 w-32 bg-secondary rounded-[1rem]">
                <p class="h-10 mt-3 w-10 bg-black ml-19"></p>
                <p class="ml-3 text-black font-alata -mb-1 mt-5 text-lg">Semua</p>
                <p class="ml-3 text-primary font-alata">116 item</p>
            </div>
            <div class="h-32 w-32 bg-primary rounded-[1rem]">
                <p class="h-10 mt-3 w-10 bg-background ml-19"></p>
                <p class="ml-3 text-background font-alata -mb-1 mt-5 text-lg">Makanan</p>
                <p class="ml-3 text-background font-alata">116 item</p>
            </div>
            <div class="h-32 w-32 bg-primary rounded-[1rem]">
                <p class="h-10 mt-3 w-10 bg-background ml-19"></p>
                <p class="ml-3 text-background font-alata -mb-1 mt-5 text-lg">Minuman</p>
                <p class="ml-3 text-background font-alata">116 item</p>
            </div>
        </div> 
        <div class="w-screen flex justify-center gap-4 h-60">
            <div class="h-67 w-49 flex-col  items-center justify-content-evenly flex  bg-white border-4 rounded-[1rem] border-primary">
                <div class="h-27 w-40 bg-black mt-4 rounded-[0.5rem]"></div>
                <div class="w-40 h-10 flex justify-center">
                    <p>Ayam Pecak Sambal Betawi</p>
                </div>
                <div class="w-full h-10 flex justify-between">
                    <p class="font-bold ml-[0.9rem] font-alata mt-2">RP400.000</p>
                </div>
                 <div class="w-full h-10 flex items-center flex-col justify-center">
                    <button type="submit" class="bg-primary  text-background h-10 w-4/5 rounded-[0.5rem]">Tambahkan</button>
                </div>
            </div>
            <div class="h-67 w-49 flex-col  items-center justify-content-evenly flex  bg-white border-4 rounded-[1rem] border-primary">
                <div class="h-27 w-40 bg-black mt-4 rounded-[0.5rem]"></div>
                <div class="w-40 h-10 flex justify-center">
                    <p>Ayam Pecak Sambal Betawi</p>
                </div>
                <div class="w-full h-10 flex justify-between">
                    <p class="font-bold ml-[0.9rem] font-alata mt-2">RP400.000</p>
                </div>
                 <div class="w-full h-10 flex items-center flex-col justify-center">
                    <button type="submit" class="bg-primary  text-background h-10 w-4/5 rounded-[0.5rem]">Tambahkan</button>
                </div>
            </div>
        </div>
</div>

@endsection