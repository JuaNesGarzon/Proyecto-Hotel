<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="bg-gradient-to-r from-black to-purple-800 min-h-screen font-sans">
    <!-- Navbar -->
    <nav class="top-0 left-0 right-0 z-50 p-4 position-sticky">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold">Hotel Deja Vu</a>
            <div class="space-x-4">
                <a href="index.php" class="text-white hover:text-gray-200">Inicio</a>
                <a href="#" class="text-white hover:text-gray-200">Habitaciones</a>
                <a href="#" class="text-white hover:text-gray-200">Contacto</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto mt-20 p-8 flex flex-wrap">
        <!-- Left Column: Booking Form -->
        <div class="w-full md:w-1/2 p-4">
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg">
                <h2 class="text-2xl font-bold text-white mb-6">Reservar Habitación</h2>
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label for="check-in" class="block text-white mb-2">Fecha de llegada</label>
                        <input type="text" id="check-in" name="check-in" class="w-full p-2 rounded-md" required>
                    </div>
                    <div>
                        <label for="check-out" class="block text-white mb-2">Fecha de salida</label>
                        <input type="text" id="check-out" name="check-out" class="w-full p-2 rounded-md" required>
                    </div>
                    <div>
                        <label for="guests" class="block text-white mb-2">Número de huéspedes</label>
                        <input type="number" id="guests" name="guests" min="1" class="w-full p-2 rounded-md" required>
                    </div>
                    <div>
                        <label for="room-type" class="block text-white mb-2">Tipo de habitación</label>
                        <select id="room-type" name="room-type" class="w-full p-2 rounded-md" required>
                            <option value="">Seleccione una opción</option>
                            <option value="standard">Estándar</option>
                            <option value="deluxe">Deluxe</option>
                            <option value="suite">Suite</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">Reservar ahora</button>
                </form>
            </div>
        </div>

        <!-- Right Column: Calendar and Room Image -->
        <div class="w-full md:w-1/2 p-4">
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg mb-6 px-6 py-11">
                <div id="calendar" class="bg-white rounded-lg p-4 w-full"></div>
            </div>
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg">
                <img src="/placeholder.svg" alt="Habitación seleccionada" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-white text-center mb-4">Imagen de la habitación seleccionada</p>
                <a href="https://wa.me/1234567890" target="_blank" class="block w-full bg-green-500 text-white text-center py-2 px-4 rounded-md hover:bg-green-600 transition duration-300">
                    <i class="bx bxl-whatsapp mr-2"></i>Contactar por WhatsApp
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-white py-16 px-4 mt-12">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                <!-- Contacts Column -->
                <div>
                    <h4 class="text-xl mb-6">Contacts</h4>
                    <address class="not-italic mb-4">
                        Baker Street 567, Los Angeles 11023<br>
                        California - US
                    </address>
                    <a href="mailto:info@hoteldejavucom" class="text-neutral-300 hover:text-white transition duration-200">
                        info@hoteldejavu.com
                    </a>
                    <div class="mt-2">
                        <a href="tel:+4344324232" class="text-neutral-300 hover:text-white transition duration-200">
                            +434 43242232
                        </a>
                    </div>
                    <!-- Social Media Icons -->
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="text-neutral-300 hover:text-white transition duration-200">
                            <i class="bx bxl-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="text-neutral-300 hover:text-white transition duration-200">
                            <i class="bx bxl-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="text-neutral-300 hover:text-white transition duration-200">
                            <i class="bx bxl-twitter text-2xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Explore Column -->
                <div>
                    <h4 class="text-xl mb-6">Explore</h4>
                    <nav class="flex flex-col gap-3">
                        <a href="/" class="text-neutral-300 hover:text-white transition duration-200">Home</a>
                        <a href="about.php" class="text-neutral-300 hover:text-white transition duration-200">About Us</a>
                        <a href="rooms.php" class="text-neutral-300 hover:text-white transition duration-200">Rooms & Suites</a>
                        <a href="news.php" class="text-neutral-300 hover:text-white transition duration-200">News & Events</a>
                        <a href="contact.php" class="text-neutral-300 hover:text-white transition duration-200">Contacts</a>
                        <a href="terms.php" class="text-neutral-300 hover:text-white transition duration-200">Terms and Conditions</a>
                    </nav>
                </div>

                <!-- Newsletter Column -->
                <div>
                    <h4 class="text-xl mb-6">Newsletter</h4>
                    <form action="subscribe.php" method="POST" class="space-y-4">
                        <div class="relative">
                            <input type="email" name="email" placeholder="Your email" class="w-full bg-neutral-800 border-neutral-700 rounded-md py-2 px-4 text-white placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-neutral-600" required>
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-white transition duration-200">
                                <i class="bx bx-envelope text-2xl"></i>
                            </button>
                        </div>
                        <p class="text-sm text-neutral-400">
                            Receive latest offers and promos without spam. You can cancel anytime.
                        </p>
                    </form>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-12 pt-8 border-t border-neutral-800 text-center text-neutral-400 text-sm">
                <p>&copy; Hotel Deja Vu - by <a href="#" class="hover:text-white transition duration-200">Ansonika</a></p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#check-in", {
                minDate: "today",
                dateFormat: "Y-m-d",
            });

            flatpickr("#check-out", {
                minDate: "today",
                dateFormat: "Y-m-d",
            });

            flatpickr("#calendar", {
                inline: true,
                mode: "range",
                dateFormat: "Y-m-d",
            });
        });
    </script>
</body>
</html>