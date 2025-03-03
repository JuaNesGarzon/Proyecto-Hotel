<?php
session_start();
include '../APP/config/conexion.php';
include '../APP/controllers/huespedController.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Obtener información del huésped
$id_huesped = $_SESSION['user_id'];
$sql_huesped = "SELECT * FROM huespedes WHERE id_huesped = ?";
$stmt = $conexion->prepare($sql_huesped);
$stmt->bind_param("i", $id_huesped);
$stmt->execute();
$result_huesped = $stmt->get_result();
$huesped = $result_huesped->fetch_assoc();

// Obtener servicios de la base de datos
$sql_servicios = "SELECT * FROM servicios";
$result_servicios = $conexion->query($sql_servicios);

// Obtener número de habitación
$numero_habitacion = isset($_GET['numero']) ? $_GET['numero'] : '';
?>

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
    <style>
        .hidden {
            display: none;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gradient-to-r from-black to-purple-800 min-h-screen font-sans">
    <!-- Navbar -->
    <nav class="top-0 left-0 right-0 z-50 p-4 position-sticky">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-3xl font-bold">Hotel Deja Vu</a>
            <div class="space-x-4">
                <a href="index.php" class="text-white text-2xl hover:text-gray-200">Inicio</a>
                <a href="habitaciones.php" class="text-white text-2xl hover:text-gray-200">Habitaciones</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto mt-20 p-8 flex flex-wrap">
        <!-- Left Column: Booking Form -->
        <div class="w-full md:w-1/2 p-4">
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg">
                <h2 class="text-2xl font-bold text-white mb-6">Reservar Habitación</h2>
                <form action="../APP/models/procesar_reserva.php" method="POST" class="space-y-4">
                    <input type="hidden" name="numero_habitacion" value="<?php echo htmlspecialchars($numero_habitacion); ?>">
                    <div>
                        <label for="numero_habitacion" class="block text-white mb-2">Número de habitación</label>
                        <input type="text" id="numero_habitacion" value="<?php echo htmlspecialchars($numero_habitacion); ?>" class="w-full p-2 rounded-md" readonly>
                    </div>
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
                    
                    <!-- Servicios Adicionales -->
                    <div>
                        <label class="block text-white mb-2">Servicios adicionales</label>
                        <?php while($servicio = $result_servicios->fetch_assoc()): ?>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="servicios[]" value="<?php echo $servicio['id_servicio']; ?>" id="servicio_<?php echo $servicio['id_servicio']; ?>" class="mr-2">
                                <label for="servicio_<?php echo $servicio['id_servicio']; ?>" class="text-white">
                                    <?php echo htmlspecialchars($servicio['nombreServicio']); ?> - $<?php echo number_format($servicio['costo'], 2); ?>
                                </label>
                            </div>
                        <?php endwhile; ?>
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
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 shadow-lg w-full">
                <img id="room-image" src="images/Diapositiva6.jpg" alt="Imagen de la habitación seleccionada" class="w-full h-64 object-cover mb-4">
                <p class="text-white text-center mb-4">Imagen de la habitación seleccionada</p>
                <a href="https://wa.me/3138494741" target="_blank" class="block w-full bg-green-500 text-white text-center py-2 px-4 rounded-md hover:bg-green-600 transition duration-300">
                    <i class="bx bxl-whatsapp mr-2"></i>Contactar por WhatsApp
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-white py-16 px-4">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                <!-- Contacts Column -->
                <div>
                    <h4 class="text-xl mb-6">Contacts</h4>
                    <address class="not-italic mb-4">
                        Baker Street 567, Los Angeles 11023<br>
                        California - US
                    </address>
                    <a href="mailto:info@hoteldejavucom"
                        class="text-neutral-300 hover:text-white transition duration-200">
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
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-300 hover:text-white transition duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-300 hover:text-white transition duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-300 hover:text-white transition duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Explore Column -->
                <div>
                    <h4 class="text-xl mb-6">Explore</h4>
                    <nav class="flex flex-col gap-3">
                        <a href="/" class="text-neutral-300 hover:text-white transition duration-200">Home</a>
                        <a href="about.php" class="text-neutral-300 hover:text-white transition duration-200">About
                            Us</a>
                        <a href="rooms.php" class="text-neutral-300 hover:text-white transition duration-200">Rooms &
                            Suites</a>
                        <a href="news.php" class="text-neutral-300 hover:text-white transition duration-200">News &
                            Events</a>
                        <a href="contact.php"
                            class="text-neutral-300 hover:text-white transition duration-200">Contacts</a>
                        <a href="terms.php" class="text-neutral-300 hover:text-white transition duration-200">Terms and
                            Conditions</a>
                    </nav>
                </div>

                <!-- Newsletter Column -->
                <div>
                    <h4 class="text-xl mb-6">Newsletter</h4>
                    <form action="subscribe.php" method="POST" class="space-y-4">
                        <div class="relative">
                            <input type="email" name="email" placeholder="Your email"
                                class="w-full bg-neutral-800 border-neutral-700 rounded-md py-2 px-4 text-white placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-neutral-600"
                                required>
                            <button type="submit"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-white transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
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
                <p>&copy; Hotel Deja Vu - by <a href="#" class="hover:text-white transition duration-200">Ansonika</a>
                </p>
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

            // Cambiar la imagen de la habitación cuando se selecciona un tipo
            const roomTypeSelect = document.getElementById('room-type');
            const roomImage = document.getElementById('room-image');

            roomTypeSelect.addEventListener('change', function() {
                switch(this.value) {
                    case 'standard':
                        roomImage.src = 'images/junior_suite.jpg';
                        break;
                    case 'deluxe':
                        roomImage.src = 'images/deluxe_room.jpg';
                        break;
                    case 'suite':
                        roomImage.src = 'images/superior_room.jpg';
                        break;
                    default:
                        roomImage.src = 'images/Diapositiva6.jpg';
                }
            });
        });

        function toggleServicesVisibility() {
            const container = document.getElementById('serviciosContainer');
            const chevron = document.getElementById('chevronIcon');
            
            container.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }
    </script>
</body>
</html>

