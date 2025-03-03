<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa & Bienestar</title>
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
    
    <!-- Spa -->
    <section class="relative h-screen bg-cover bg-center" style="background-image: url('./images/spa.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white max-w-2xl px-6 fade-in">
                <h1 class="text-5xl font-bold">Spa & Bienestar</h1>
                <p class="mt-4 text-lg">Relájate en nuestro spa de lujo y disfruta de tratamientos diseñados para tu bienestar y tranquilidad.</p>
            </div>
        </div>
    </section>
    
    <!-- Servicios del Spa -->
    <section class="py-16 px-6 bg-white">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">Nuestros Servicios</h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-200 p-6 text-center rounded-lg shadow-md fade-in">
                <img src="./images/masaje.jpg" alt="Masaje relajante" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-2xl font-semibold">Masajes Relajantes</h3>
                <p class="text-gray-600 mt-2">Disfruta de un masaje terapéutico para aliviar el estrés y mejorar la circulación.</p>
            </div>
            <div class="bg-gray-200 p-6 text-center rounded-lg shadow-md fade-in">
                <img src="./images/facial.jpg" alt="Tratamiento facial" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-2xl font-semibold">Tratamientos Faciales</h3>
                <p class="text-gray-600 mt-2">Rejuvenece tu piel con nuestros exclusivos tratamientos hidratantes y revitalizantes.</p>
            </div>
            <div class="bg-gray-200 p-6 text-center rounded-lg shadow-md fade-in">
                <img src="./images/sauna.jpg" alt="Sauna y baño de vapor" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-2xl font-semibold">Sauna y Baño de Vapor</h3>
                <p class="text-gray-600 mt-2">Purifica tu cuerpo y relájate en nuestras modernas instalaciones de sauna.</p>
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
