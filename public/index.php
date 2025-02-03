<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../APP/controllers/huespedController.php';

$loggedIn = isset($_SESSION['user_id']) && isset($_SESSION['user_name']);
if (!$loggedIn) {
    header("Location: ../APP/form/formulario.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'serif': ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="min-h-screen">
    
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 absolute">
<?php 
    // if (isset($_SESSION['user_id'])) {
    //     echo "<p><a href='logout.php'>Cerrar sesión</a></p>";
    // } else {
    //     echo "<p><a href='../APP/form/formulario.php'>Ir al formulario de registro/inicio de sesión</a></p>";
    // }
    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
        header("Location: ../APP/form/formulario.php");
        exit();
    }
    ?>
    <h1 class="text-center text-white">Bienvenido,  <?php echo $_SESSION['user_name'] ?></h1>
        <div class="container mx-auto px-4 flex items-center justify-between h-20">
            <a href="/" class="text-2xl font-serif text-white">
                HOTEL DEJA VU
            </a>
            <div class="flex items-center gap-4">
                <a href="reservar.php"
                    class="hidden sm:inline-flex px-4 py-2 bg-white/10 text-white border border-white/20 hover:bg-white/20 rounded-md">
                    Reservar Ahora
                </a>
                <button id="menuBtn" class="text-white p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu"
            class="fixed inset-y-0 right-0 w-64 bg-white transform translate-x-full transition-transform duration-200 ease-in-out">
            <div class="p-6">
                <button id="closeMenu" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <nav class="mt-8">
                    <a href="/" class="block py-2.5 text-gray-600 hover:text-gray-900">Inicio</a>
                    <a href="habitaciones.php" class="block py-2.5 text-gray-600 hover:text-gray-900">Habitaciones</a>
                    <a href="restaurante.php" class="block py-2.5 text-gray-600 hover:text-gray-900">Restaurante</a>
                    <a href="spa.php" class="block py-2.5 text-gray-600 hover:text-gray-900">Spa</a>
                    <a href="contacto.php" class="block py-2.5 text-gray-600 hover:text-gray-900">Contacto</a>
                    <form method="POST" class="space-y-4">
                        <button type="submit" name="cerrar_sesion" class="cerrar_sesion" id="cerrar_sesion">Cerrar sesión</button>
                    </form>
                    <!-- <a href='logout.php' class="block py-2.5 text-gray-600 hover:text-gray-900">Cerrar sesión</a> -->
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="relative min-h-screen flex flex-col items-center justify-center">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="../Assets/videos/3190-166339081_small.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 bg-[url('/images/hero.jpg')] bg-cover bg-center" style="z-index: -1;"></div>

        <div
            class="container mx-auto px-4 relative z-10 flex flex-col items-center justify-center gap-6 py-32 text-center">
            <p class="text-white/80 text-lg font-medium tracking-wider uppercase">Experiencia de Hotel de Lujo</p>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-serif text-white max-w-4xl">
                Una Experiencia Única Donde Hospedarse
            </h1>

            <!-- Booking Form -->
            <form action="procesar-reserva.php" method="POST"
                class="w-full max-w-4xl mx-auto p-6 bg-white/10 backdrop-blur-md rounded-lg">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
                    <div class="space-y-2">
                        <label for="check-in" class="block text-white">Check in</label>
                        <input type="date" id="check-in" name="check-in"
                            class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white" required>
                    </div>
                    <div class="space-y-2">
                        <label for="check-out" class="block text-white">Check out</label>
                        <input type="date" id="check-out" name="check-out"
                            class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white" required>
                    </div>
                    <div class="space-y-2">
                        <label for="adults" class="block text-white">Adultos</label>
                        <input type="number" id="adults" name="adults" min="1" value="2"
                            class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white" required>
                    </div>
                    <div class="space-y-2">
                        <label for="children" class="block text-white">Niños</label>
                        <input type="number" id="children" name="children" min="0" value="0"
                            class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white">
                    </div>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-2 bg-white text-black hover:bg-white/90 rounded-md">
                    Buscar
                </button>
            </form>
        </div>
    </main>

    <script>
        // Mobile menu functionality
        const menuBtn = document.getElementById('menuBtn');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('translate-x-full');
        });

        closeMenu.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
        });

        // Set minimum dates for check-in and check-out
        const checkIn = document.getElementById('check-in');
        const checkOut = document.getElementById('check-out');

        const today = new Date().toISOString().split('T')[0];
        checkIn.min = today;

        checkIn.addEventListener('change', () => {
            checkOut.min = checkIn.value;
            if (checkOut.value && checkOut.value < checkIn.value) {
                checkOut.value = checkIn.value;
            }
        });
    </script>
    <!-- Add this section after the main hero section in index.html -->

    <!-- About Section -->
    <section class="py-20 px-4 bg-white">
        <div class="container mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="max-w-xl">
                    <h3 class="text-neutral-600 uppercase tracking-wider mb-4">ABOUT US</h3>
                    <h2 class="text-4xl md:text-5xl font-serif text-neutral-800 mb-6">
                        Servicios personalizados y la experiencia de vacaciones únicas
                    </h2>
                    <p class="text-lg text-neutral-600 mb-4">
                        Vivamus volutpat eros pulvinar velit laoreet, sit amet egestas erat dignissim.
                    </p>
                    <p class="text-neutral-600 mb-8">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium,
                        totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
                        dicta sunt explicabo.
                    </p>
                    <p class="font-handwriting text-2xl text-neutral-800">
                        Maria...la Propietaria
                    </p>
                </div>

                <!-- Images -->
                <div class="relative">
                    <!-- Main Image (Bedroom) -->
                    <div class="relative z-10 rounded-lg overflow-hidden shadow-xl">
                        <img src="images/bedroom.jpg" alt="Habitación de lujo" class="w-full h-[600px] object-cover">
                    </div>
                    <!-- Overlapping Image (Bathroom) -->
                    <div class="absolute top-1/4 -left-1/4 w-2/3 rounded-lg overflow-hidden shadow-xl">
                        <img src="images/bathroom.jpg" alt="Baño de lujo" class="w-full h-[400px] object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add this to the head section for the handwriting font -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

    <!-- Add this to your existing Tailwind config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'serif': ['Playfair Display', 'serif'],
                        'handwriting': ['Dancing Script', 'cursive'],
                    }
                }
            }
        }
    </script>
    <!-- Rooms & Suites Section -->
    <section class="py-20 px-4 bg-neutral-50">
        <div class="container mx-auto">
            <!-- Section Header -->
            <div class="max-w-xl mb-12">
                <h3 class="text-neutral-600 uppercase tracking-wider mb-4">LUXURY EXPERIENCE</h3>
                <h2 class="text-4xl md:text-5xl font-serif text-neutral-800">
                    Rooms & Suites
                </h2>
            </div>

            <!-- Rooms Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <!-- Junior Suite Card -->
                <div class="group relative rounded-xl overflow-hidden">
                    <img src="images/junior-suite.jpg" alt="Junior Suite"
                        class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <p class="text-sm mb-2">FROM $250/NIGHT</p>
                        <h3 class="text-2xl font-serif">Junior Suite</h3>
                    </div>
                    <a href="rooms.php?type=junior-suite" class="absolute inset-0" aria-label="Ver Junior Suite">
                        <span class="sr-only">Ver detalles de Junior Suite</span>
                    </a>
                </div>

                <!-- Deluxe Room Card -->
                <div class="group relative rounded-xl overflow-hidden">
                    <img src="images/deluxe-room.jpg" alt="Deluxe Room"
                        class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <p class="text-sm mb-2">FROM $190/NIGHT</p>
                        <h3 class="text-2xl font-serif">Deluxe Room</h3>
                    </div>
                    <a href="rooms.php?type=deluxe-room" class="absolute inset-0" aria-label="Ver Deluxe Room">
                        <span class="sr-only">Ver detalles de Deluxe Room</span>
                    </a>
                </div>

                <!-- Superior Room Card -->
                <div class="group relative rounded-xl overflow-hidden">
                    <img src="images/superior-room.jpg" alt="Superior Room"
                        class="w-full aspect-[4/3] object-cover transition duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <p class="text-sm mb-2">FROM $240/NIGHT</p>
                        <h3 class="text-2xl font-serif">Superior Room</h3>
                    </div>
                    <a href="rooms.php?type=superior-room" class="absolute inset-0" aria-label="Ver Superior Room">
                        <span class="sr-only">Ver detalles de Superior Room</span>
                    </a>
                </div>
            </div>

            <!-- View All Button -->
            <div class="flex justify-end">
                <a href="rooms.php"
                    class="inline-flex items-center px-6 py-3 border border-neutral-300 rounded-full hover:bg-neutral-100 transition duration-200">
                    View all Rooms
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- Facilities Section -->
    <section class="py-20 px-4 bg-white">
        <div class="container mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h3 class="text-neutral-600 uppercase tracking-wider mb-4">HOTEL DEJA VU</h3>
                <h2 class="text-4xl md:text-5xl font-serif text-neutral-800">
                    Main Facilities
                </h2>
            </div>

            <!-- Facilities Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Private Parking -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1" class="w-full h-full text-neutral-600">
                            <path d="M3 18h18v2H3v-2z" />
                            <path d="M6 12h12v6H6v-6z" />
                            <path d="M8 6h8v6H8V6z" />
                            <path d="M12 3l6 3H6l6-3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif mb-4">Private Parking</h3>
                    <p class="text-neutral-600">
                        Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.
                    </p>
                </div>

                <!-- High Speed Wifi -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1" class="w-full h-full text-neutral-600">
                            <path d="M12 19.5v-15" />
                            <path d="M5 12.5c7-4 7 4 14 0" />
                            <path d="M3 8.5c9-6 9 6 18 0" />
                            <path d="M1 4.5c11-8 11 8 22 0" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif mb-4">High Speed Wifi</h3>
                    <p class="text-neutral-600">
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium.
                    </p>
                </div>

                <!-- Bar & Restaurant -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1" class="w-full h-full text-neutral-600">
                            <path d="M8 21h8" />
                            <path d="M12 21v-4" />
                            <path d="M12 13c3.5 0 6-2.5 6-6c0-4-2.5-6-6-6S6 3 6 7c0 3.5 2.5 6 6 6z" />
                            <path d="M6 7h12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif mb-4">Bar & Restaurant</h3>
                    <p class="text-neutral-600">
                        Similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.
                    </p>
                </div>

                <!-- Swimming Pool -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1" class="w-full h-full text-neutral-600">
                            <path d="M2 20c2-2 4-2 6 0c2-2 4-2 6 0c2-2 4-2 6 0" />
                            <path d="M2 16c2-2 4-2 6 0c2-2 4-2 6 0c2-2 4-2 6 0" />
                            <path d="M2 12c2-2 4-2 6 0c2-2 4-2 6 0c2-2 4-2 6 0" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif mb-4">Swimming Pool</h3>
                    <p class="text-neutral-600">
                        Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                    </p>
                </div>
            </div>
        </div>
    </section>
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
</body>

</html>
