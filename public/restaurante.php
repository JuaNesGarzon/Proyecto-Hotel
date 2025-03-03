<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante & Spa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcout icon" href="../public/images/logo1.ico">
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }
        .show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100">
    
    <!-- Restaurante -->
    <section class="relative h-screen bg-cover bg-center" style="background-image: url('./images/Diapositiva4.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white max-w-2xl px-6 fade-in">
                <h1 class="text-5xl font-bold">Restaurante Gourmet</h1>
                <p class="mt-4 text-lg">Disfruta de una experiencia culinaria única con sabores exquisitos preparados por nuestros chefs expertos.</p>
            </div>
        </div>
    </section>
    
    <!-- Platos destacados -->
    <section class="py-16 px-6 bg-white">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">Platos Destacados</h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-200 p-6 text-center rounded-lg shadow-md fade-in">
                <img src="./images/pasta.jpg" alt="Pasta" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-2xl font-semibold">Pasta Alfredo</h3>
                <p class="text-gray-600 mt-2">Una deliciosa pasta con salsa cremosa de queso parmesano y pollo.</p>
            </div>
            <div class="bg-gray-200 p-6 text-center rounded-lg shadow-md fade-in">
                <img src="./images/ensalada.jpg" alt="Ensalada" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-2xl font-semibold">Ensalada César</h3>
                <p class="text-gray-600 mt-2">Lechuga fresca, crutones, aderezo césar y queso parmesano.</p>
            </div>
            <div class="bg-gray-200 p-6 text-center rounded-lg shadow-md fade-in">
                <img src="./images/filete.jpg" alt="Filete Mignon" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-2xl font-semibold">Filete Mignon</h3>
                <p class="text-gray-600 mt-2">Carne de res jugosa con un toque de mantequilla de ajo.</p>
            </div>
        </div>
    </section>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".fade-in");
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    }
                });
            }, { threshold: 0.3 });
            elements.forEach(element => observer.observe(element));
        });
    </script>
</body>
</html>
