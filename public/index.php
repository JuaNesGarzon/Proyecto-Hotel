<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="bg-gray-100">
    <h1>hola</h1>
    
    <?php 
    include ('../APP/config/conexion.php');
    ?>
<header class="bg-transparent absolute w-full z-10">
        <section class="max-w-7xl mx-auto px-4 py-4">
            <nav class="flex items-center justify-between">
                <div class="text-white text-lg font-serif tracking-wide text-center">
                    <div class="text-2xl font-bold">DEJÁ VU</div>
                    <div class="text-sm font-light">HOTEL</div>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="button" class="bg-[#A39B8B] text-white px-6 py-2 rounded-md font-normal hover:bg-[#8A8270] transition">
                        Book Now
                    </button>
                    <button id="hamburguer" type="button" class="text-white text-2xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </nav>
        </section>
    </header>
    <main class="relative min-h-screen">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="./assets/videos/3190-166339081_small.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen text-white text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-wider">A UNIQUE EXPERIENCE</h1>
            <p class="text-2xl md:text-4xl mb-12">WHERE TO STAY</p>
            <p class="text-sm mb-8 tracking-widest">LUXURY HOTEL EXPERIENCE</p>
        </div>
    </main>
    <aside id="menu" class="fixed top-0 right-0 h-full w-64 bg-white text-gray-800 shadow-lg z-50 p-6 transform translate-x-full transition-transform duration-300 ease-in-out">
        <button id="closeMenu" type="button" class="text-2xl absolute top-4 right-4 text-gray-800 focus:outline-none">
            <i class="fa-solid fa-x"></i>
        </button>
        <div class="mt-8">
            <h2 class="text-lg font-serif font-bold mb-4">DEJÁ VU HOTEL</h2>
            <ul class="space-y-4">
                <li><a href="#" class="block text-gray-700 hover:text-gray-900">Home</a></li>
                <li><a href="#" class="block text-gray-700 hover:text-gray-900">Rooms & Suites</a></li>
                <li><a href="#" class="block text-gray-700 hover:text-gray-900">About</a></li>
                <li><a href="#" class="block text-gray-700 hover:text-gray-900">Restaurant</a></li>
                <li><a href="#" class="block text-gray-700 hover:text-gray-900">News & Events</a></li>
                <li><a href="#" class="block text-gray-700 hover:text-gray-900">Contact</a></li>
            </ul>
            <div class="mt-8">
                <p class="text-sm text-gray-600">INFO AND BOOKINGS</p>
                <p class="font-bold text-gray-900">+41 934 121 1334</p>
            </div>
        </div>
    </aside>
</body>
</html>
