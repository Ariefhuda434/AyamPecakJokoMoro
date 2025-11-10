<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Ayam Pecak Joko Moro</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#421512]">
<div class="h-3/4 bg-[#FFF8E7] w-full fixed bottom-0 rounded-tl-[5rem] flex justify-center p-4"> 
    <form action="" class="w-full">
   <div class="flex justify-center w-full"> 
    
    <div class="flex flex-col items-center space-y-4 w-full max-w-sm"> 
        
        <p class="text-2xl font-bold text-[#421512] mt-10 mb-6 font-sans">Selamat Datang</p>
        
        <div class="w-full flex flex-col items-center">
            <p class="mb-2 text-xl font-medium w-4/5 text-left font-sans">Nama Pengguna</p>
            <input 
                type="text" 
                name="username" 
                placeholder="Masukan Nama Pengguna" 
                value="{{ old('username') }}"
                class="w-4/5 border-4 border-[#421512] rounded-tl-[1rem] rounded-br-[1rem] 
                       py-3 px-6 focus:outline-none focus:ring-4 focus:ring-[#421512] 
                       placeholder-gray-500 font-sans text-lg" 
            />
        </div>
        
        <div class="w-full flex flex-col items-center">
            <p class="mb-2 text-xl font-medium w-4/5 text-left font-sans">Kata Sandi</p>
            <input 
                type="password" name="password" 
                placeholder="*******" 
                class="w-4/5 border-4 border-[#421512] rounded-tl-[1rem] rounded-br-[1rem] 
                       py-3 px-6 focus:outline-none focus:ring-4 focus:ring-[#421512] 
                       placeholder-gray-500 font-sans text-lg" 
            />
        </div>

        <div class="w-4/5 flex justify-between items-center mt-2">
            
            <label class="flex items-center space-x-1 cursor-pointer">
                <input type="checkbox" name="remember" id="remember" 
                       class="form-checkbox h-4 w-4 text-[#421512] border-gray-300 rounded focus:ring-[#421512]">
                <p class="text-[#421512] text-sm font-medium select-none font-sans">Ingat Saya</p>
            </label>
            
            <a href="#" class="underline text-sm font-medium text-[#421512] hover:text-red-700 font-sans">
                Lupa Sandi?
            </a>
        </div>
        <button 
            type="submit" 
            class="bg-[#421512] w-4/5 py-3 rounded-[10px] text-[#FFF8E7] font-bold mt-3 hover:bg-red-900 transition font-sans">
            Masuk
        </button>  
    </div>
</div>
    </form>
    
</div>
</div>
</body>
</html>