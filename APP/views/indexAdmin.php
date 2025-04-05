<?php 
include __DIR__ . '/../config/conexion.php';
session_start();
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 1) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// cierre de sesion 
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: ../form/formEmpleado.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'coral': '#ff7f50',
                        'primary': '#33423a'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-primary font-montserrat min-h-screen text-white">
    <!-- Sidebar móvil -->
    <div class="lg:hidden fixed inset-y-0 left-0 z-30 w-64 bg-white/10 backdrop-blur-lg transform transition-transform duration-300 ease-in-out" 
         id="mobile-menu">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-center h-16 border-b border-white/20">
                <h1 class="text-xl font-playfair font-bold">Hotel Deja Vu</h1>
            </div>
            <nav class="flex-grow py-4">
                <a href="#" class="flex items-center px-6 py-3 text-white hover:bg-white/10">
                    <i class='bx bxs-dashboard mr-3 text-xl'></i>
                    <span>Inicio</span>
                </a>
                <a href="./CRUD/CRUDadmin.php" class="flex items-center px-6 py-3 text-white hover:bg-white/10">
                    <i class='bx bx-data mr-3 text-xl'></i>
                    <span>CRUD</span>
                </a>
                <a href="informes.php" class="flex items-center px-6 py-3 text-white hover:bg-white/10">
                    <i class='bx bx-line-chart mr-3 text-xl'></i>
                    <span>Informes Financieros</span>
                </a>
                <a href="CuentasProv.php" class="flex items-center px-6 py-3 text-white hover:bg-white/10">
                    <i class='bx bx-receipt mr-3 text-xl'></i>
                    <span>Cuentas de Proveedores</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="lg:ml-0">
        <header class="bg-white/10 backdrop-blur-lg">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-playfair font-bold mb-6">Panel de Administración</h1>
                
                <!-- Navegación desktop -->
                <nav class="hidden lg:flex space-x-6">
                    <a href="indexAdmin.php" class="flex items-center text-white hover:text-white/80 transition-colors">
                        <i class='bx bxs-dashboard mr-2 text-xl'></i>
                        <span>Inicio</span>
                    </a>
                    <a href="./CRUD/CRUDadmin.php" class="flex items-center text-white hover:text-white/80 transition-colors">
                        <i class='bx bx-data mr-2 text-xl'></i>
                        <span>CRUD</span>
                    </a>
                    <a href="informes.php" class="flex items-center text-white hover:text-white/80 transition-colors">
                        <i class='bx bx-line-chart mr-2 text-xl'></i>
                        <span>Informes Financieros</span>
                    </a>
                    <a href="CuentasProv.php" class="flex items-center text-white hover:text-white/80 transition-colors">
                        <i class='bx bx-receipt mr-2 text-xl'></i>
                        <span>Cuentas de Proveedores</span>
                    </a>
                </nav>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-2 border-white/20 rounded-xl h-96 bg-white/10 backdrop-blur-lg p-6">
                    <!-- Contenido del panel -->
                </div>
            </div>
        </main>
    </div>

    <!-- Perfil y cerrar sesión -->
    <div class="fixed top-0 right-0 p-4 flex items-center space-x-4">
        <div class="flex items-center bg-coral/70 backdrop-blur-lg rounded-xl px-4 py-2">
            <i class='bx bxs-user-circle text-2xl mr-2'></i>
            <span class="font-medium">Admin <?php echo $_SESSION['nombre']; ?></span>
        </div>
        <form method="POST" class="inline-block">
            <button type="submit" name="cerrar_sesion" 
                    class="bg-white/20 backdrop-blur-lg hover:bg-red-600 text-white px-4 py-2 rounded-xl transition-colors flex items-center">
                <i class='bx bx-log-out mr-2'></i>
                Cerrar sesión
            </button>
        </form>
    </div>

    <!-- Toggle menú móvil -->
    <button class="lg:hidden fixed bottom-4 right-4 bg-white/10 backdrop-blur-lg p-3 rounded-full text-white" 
            onclick="document.getElementById('mobile-menu').classList.toggle('-translate-x-full')">
        <i class='bx bx-menu text-2xl'></i>
    </button>
</body>
</html>