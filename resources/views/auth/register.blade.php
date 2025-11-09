<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Ayam Pecak Joko Moro</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#4C1D1D] flex items-center justify-center min-h-screen">

    <div class="bg-[#FAF3E0] rounded-3xl shadow-lg w-[400px] p-8 text-center">
        <img src="/images/logo.png" alt="Ayam Pecak Joko Moro" class="mx-auto mb-4 w-24">
        <h1 class="text-2xl font-bold text-[#4C1D1D] mb-6">REGISTRASI</h1>

        <form action="#" method="POST" class="space-y-4 text-left">
            <div>
                <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Nama Pengguna</label>
                <input type="text" placeholder="Masukkan Nama Pengguna" class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Nomor Telepon</label>
                <input type="tel" placeholder="0812xxxxxxxxxx" class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Peran</label>
                <select class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
                    <option>Waiter</option>
                    <option>Manajer</option>
                    <option>Kasir</option>
                    <option>Karyawan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#4C1D1D] mb-1">Kata Sandi</label>
                <input type="password" placeholder="***********" class="w-full px-4 py-2 rounded-md border-gray-300 focus:ring-2 focus:ring-[#4C1D1D] focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-[#4C1D1D] text-white py-2 rounded-md font-semibold hover:bg-[#3b1414] transition">DAFTAR</button>
        </form>

        <p class="text-sm text-[#4C1D1D] mt-4">
            Sudah memiliki akun?
            <a href="/login" class="font-semibold italic hover:underline">Masuk</a>
        </p>
    </div>

</body>
</html>
