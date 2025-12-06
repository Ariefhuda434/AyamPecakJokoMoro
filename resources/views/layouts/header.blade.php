    @php
        $user = Auth::user();
        $roleSlug = $user->role->slug ?? 'guest'; 
        
        $dashboardRoute = match($roleSlug) {
            'manager' => route('dashboard.view'),
            'waiter' => route('order.index'), 
            'cashier' => route('cashier.view'),
            default => '/' 
        };
    @endphp

    <div x-data="{ isSidebarOpen: true }" @click="isSidebarOpen = false" > 
    
@auth
    <div :class="{'ml-64': isSidebarOpen, 'ml-0': !isSidebarOpen}"
         class="flex items-center justify-between p-4 bg-white shadow-md transition-all duration-300 ease-in-out sticky top-0 z-30">
        
        <button x-show="!isSidebarOpen" @click.stop="isSidebarOpen = true"
                class="h-10 w-10 flex items-center justify-center bg-primary rounded-full text-white transition hover:bg-opacity-80">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
           <h1 class="text-primary font-alata ml-4 text-2xl mr-auto">
            @if (Request::is('manager/karyawan*'))
                    Manajemen Karyawan
            @elseif (Request::is('manager/stock*'))
                    Manajemen Stok
            @elseif (Request::is('order*'))
                    Pemesanan
            @elseif (Request::is('transactions*'))
                    Transaksi
            @elseif (Request::is('dashboard'))
                    Dashboard Utama
            @else
                    Selamat Datang
            @endif
           </h1>

        <div class="flex items-center gap-4">
            
            <button class="relative p-1 rounded-full hover:bg-gray-100 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-primary">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>
                <span class="absolute top-1 right-2 w-2 h-2 bg-secondary rounded-full border border-white"></span>
            </button>
            
            <div class="h-8 w-[1px] bg-gray-300 mx-2"></div>
            
            <div class="cursor-pointer">
                <span class="text-sm font-medium text-gray-700 hidden sm:inline">{{ Auth::user()->name_employee ?? 'Pengguna' }}</span>
            </div>
            
        </div>
    </div>
@endauth
        
        <header :class="{'-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen}"
            @click.stop
            class="fixed top-0 left-0 h-screen bg-primary w-64 z-50 flex flex-col justify-between 
                       transition-transform duration-300 ease-in-out">

           

            <nav class="px-6 py-8 overflow-y-auto flex-grow">
               <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-24">
        </div>

                <ul class="flex flex-col gap-3 text-white font-medium">
                    
                    <li><a href="{{ $dashboardRoute }}" class="flex items-center gap-3 transition-colors px-3 py-2 rounded-lg {{ Request::is(ltrim(parse_url($dashboardRoute, PHP_URL_PATH), '/')) || Request::is('dashboard') ? 'bg-[#D4A017] text-[#421512]' : 'hover:bg-[#D4A017] hover:text-[#421512]' }}"><span class="rounded-full bg-white h-8 w-8"></span>Dashboard</a></li>
                    
                    @if ($roleSlug === 'manager')
                    <li><a href="{{ route('employee.index') }}" class="flex items-center gap-3 transition-colors px-3 py-2 rounded-lg {{ Request::is('manager/karyawan*') ? 'bg-[#D4A017] text-[#421512]' : 'hover:bg-[#D4A017] hover:text-[#421512]' }}"><span class="rounded-full bg-white h-8 w-8"></span>Manajemen Karyawan</a></li>
                    <li><a href="{{ route('stock.index') }}" class="flex items-center gap-3 transition-colors px-3 py-2 rounded-lg {{ Request::is('manager/stock*') ? 'bg-[#D4A017] text-[#421512]' : 'hover:bg-[#D4A017] hover:text-[#421512]' }}"><span class="rounded-full bg-white h-8 w-8"></span>Manajemen Stok</a></li>
                    @endif
                    
                    @if ($roleSlug === 'waiter') 
                    <li><a href="{{ route('order.index') }}" class="flex items-center gap-3 transition-colors px-3 py-2 rounded-lg {{ Request::is('order*') ? 'bg-[#D4A017] text-[#421512]' : 'hover:bg-[#D4A017] hover:text-[#421512]' }}"><span class="rounded-full bg-white h-8 w-8"></span>Order</a></li>
                    @endif
                    
                    @if ($roleSlug === 'cashier') 
                    <li><a href="{{ route('cashier.view') }}" class="flex items-center gap-3 transition-colors px-3 py-2 rounded-lg {{ Request::is('transactions*') ? 'bg-[#D4A017] text-[#421512]' : 'hover:bg-[#D4A017] hover:text-[#421512]' }}"><span class="rounded-full bg-white h-8 w-8"></span>Transaksi</a></li>
                    @endif
                </ul>
            </nav>

            <div class="px-6 pb-8">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-3 text-white font-medium hover:bg-[#C84B31] transition-colors px-3 py-2 rounded-lg w-full">
                        <span class="rounded-full bg-white h-8 w-8"></span>
                        Keluar
                    </button>
                </form>
            </div>
        </header>


        <main :class="{'ml-64': isSidebarOpen, 'ml-0': !isSidebarOpen}" 
              class="min-h-screen transition-all duration-300 ease-in-out p-4">
            @yield('content')
        </main>
        
    </div>