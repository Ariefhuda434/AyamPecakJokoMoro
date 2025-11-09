<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Ayam Pecak Joko Moro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#4C1D1D] flex items-center justify-center min-h-screen">

    <div class="flex flex-col items-center mt-8 sm:mt-12">
        <!-- Logo di atas box -->
        <img src="/images/logo.png" alt="Ayam Pecak Joko Moro" 
             class="w-20 sm:w-24 mb-[-30px] sm:mb-[-40px] z-10">

        <!-- Box Form -->
        <div class="bg-[#FAF3E0] rounded-3xl shadow-lg w-11/12 max-w-[400px] p-6 pt-15 text-center relative
            sm:max-w-md sm:w-[600px] sm:p-10 lg:max-w-lg lg:w-[600px] lg:p-20">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#4C1D1D] mb-6">REGISTRASI</h1>

            <form action="#" method="POST" class="space-y-4 text-left">
                <div>
                    <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Nama Pengguna</label>
                    <input type="text" placeholder="Masukkan Nama Pengguna"
                           class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Nomor Telepon</label>
                    <input type="tel" placeholder="0812xxxxxxxxxx"
                           class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Peran</label>
                    <select class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
                        <option>Manajer</option>
                        <option>Kasir</option>
                        <option>Karyawan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Kata Sandi</label>
                    <input type="password" placeholder="***********"
                           class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
                </div>

                <button type="submit"
                        class="w-full bg-[#4C1D1D] text-white py-2 rounded-md font-semibold hover:bg-[#3b1414] transition">
                    DAFTAR
                </button>
            </form>

            <p class="text-sm text-[#4C1D1D] mt-4 text-center">
                Sudah memiliki akun?
                <a href="/login" class="font-semibold italic hover:underline">Masuk</a>
            </p>
        </div>
    </div>

</body>
</html>
