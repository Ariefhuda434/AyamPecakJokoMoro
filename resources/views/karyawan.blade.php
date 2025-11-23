@extends('layouts.app')

@section('title','karyawan')

@section('content')

<div class="h-screen w-screen">
      {{-- bagian atas ni --}}
        <div class="h-18 w-screen flex items-center">
            <p class="h-12 w-12 bg-primary ml-3 rounded-full"></p>
            <p class=""><span class="text-primary font-alata text-2xl ml-2">Karyawan</span></p>
            <span class="h-5 w-5 bg-secondary rounded-full ml-29"></span>
            <span class="h-9 rounded-full ml-5 w-[3px] bg-primary"></span>
            <span class="h-12 w-12 bg-white rounded-full border-2 border-text-bg-1 ml-5"></span>
        </div>
        {{-- bagian karyawn --}}
        <div class="h-18  w-full flex items-center justify-between">
          <p class="ml-10 font-alata">Karyawan(8)</p>
            <div class="mr-10 bg-secondary p-2 text-white font-alata rounded-lg">Tambah Karyawan</div>
        </div>
       <div class="bg-white shadow-lg rounded-lg p-4">
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    ID
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Handphone
                </th>
                <th scope="col" class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        
        <tbody class="bg-white divide-y divide-gray-200">
            
            <tr>
                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #123
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                    Budi Mancut
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                    08126378793
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                </td>
            </tr>

            <tr>
                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #124
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                    Siti Aminah
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                    085711223344
                </td>
                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
  </div>
  {{-- form daftar karyawan --}}
  <div class="h-screen overflow-visible w-full bg-background fixed"></div>
</div>

@endsection