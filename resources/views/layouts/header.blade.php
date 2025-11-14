<header class="fixed top-0 left-0 h-screen  w-64 z-50 flex flex-col justify-between">
    <div class="hidden">

  <nav class="px-6 py-8 overflow-y-auto">
    <div class="flex items-center justify-center mb-8">
      <div class="bg-black h-30 w-30"></div>
    </div>

    <ul class="flex flex-col gap-3 text-white font-medium">
      <li>
        <a href="#"
          class="flex items-center gap-3 hover:bg-[#D4A017] hover:text-[#421512] transition-colors px-3 py-2 rounded-lg">
          <span class="rounded-full bg-white h-8 w-8"></span>
          Dashboard
        </a>
      </li>
      <li>
        <a href="/order"
          class="flex items-center gap-3 {{ Request::is('order') ? 'bg-[#D4A017] text-[#421512]' : 'hover:bg-[#D4A017] hover:text-[#421512]' }} transition-colors px-3 py-2 rounded-lg">
          <span class="rounded-full bg-white h-8 w-8"></span>
          Order
        </a>
      </li>
      <li>
        <a href="#"
          class="flex items-center gap-3 hover:bg-[#D4A017] hover:text-[#421512] transition-colors px-3 py-2 rounded-lg">
          <span class="rounded-full bg-white h-8 w-8"></span>
          Transaksi
        </a>
      </li>
      <li>
        <a href="#"
          class="flex items-center gap-3 hover:bg-[#D4A017] hover:text-[#421512] transition-colors px-3 py-2 rounded-lg">
          <span class="rounded-full bg-white h-8 w-8"></span>
          Database
        </a>
      </li>
      <li>
        <a href="#"
          class="flex items-center gap-3 hover:bg-[#D4A017] hover:text-[#421512] transition-colors px-3 py-2 rounded-lg">
          <span class="rounded-full bg-white h-8 w-8"></span>
          Karyawan
        </a>
      </li>
    </ul>
  </nav>

  <div class="px-6 pb-8">
    <button
      class="flex items-center gap-3 text-white font-medium hover:bg-[#C84B31] transition-colors px-3 py-2 rounded-lg w-full">
      <span class="rounded-full bg-white h-8 w-8"></span>
      Keluar
    </button>
  </div>
    </div>

</header>
