<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ayam Pecak Joko Moro</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#421512]">

<div class="h-3/4 bg-[#FFF8E7] w-full fixed bottom-0 rounded-tl-[5rem] flex justify-center p-4"> 
<form action="" class="w-full">
   <div class="flex justify-center w-full"> 
    
    <div class="flex flex-col items-center space-y-4 w-full max-w-sm"> 
        
        <p class="text-4xl font-medium text-[#421512] mt-10 mb-6 font-neue">Selamat Datang</p>
      <div class="w-full flex flex-col items-center relative">
    <p class="mb-2 text-2sm ml-10 font-light text-primary w-4/5 text-left font-alata">
        Nama Pengguna
    </p>

    <div class="relative w-4/5">
        <input 
            type="text" 
            name="username" 
            placeholder="Masukan Nama Pengguna" 
            value="{{ old('username') }}"
            class="peer w-full border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                   py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                     placeholder-gray-500 font-sans text-lg" 
        />
        
    </div>
</div>

        
        <div class="w-full flex flex-col items-center">
            <p class="mb-2 text-2sm ml-10 text-primary font-light w-4/5 text-left font-alata">Kata Sandi</p>
            <input 
                type="password" name="password" 
                placeholder="*******" 
                class="w-4/5 border-4 border-primary rounded-tl-[1rem] rounded-br-[1rem] 
                       py-3 px-6 outline-none transition-all focus:border-secondary duration-500 ease-in-out
                       placeholder-gray-500 font-sans text-lg tranition ease-in-out duration-400" 
            />
        </div>

        <div class="w-4/5 flex justify-between items-center mt-2">
            
            <label class="flex items-center space-x-1 cursor-pointer">
                <input type="checkbox" name="remember" id="remember" 
                       class="form-checkbox h-4 w-4 text-[#421512] border-gray-300 rounded focus:ring-[#421512]">
                <p class="text-primary text-sm font-medium select-none font-sans">Ingat Saya</p>
            </label>
            
            <a href="#" class="underline text-sm font-medium text-[#421512] hover:text-red-700 font-sans">
                Belum punya akun?
            </a>
        </div>
        <button 
            type="submit" 
            class="bg-primary w-4/5 py-3 rounded-[10px] text-background  mt-3 hover:bg-red-900 transition font-alata">
            Daftar
        </button>  
    </div>
</div>
    </form>
    
</div>
</div>
</body>
</html>