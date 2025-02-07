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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .sidebar-hover:hover .sidebar-content {
            width: 16rem;
        }
        .sidebar-hover:hover .sidebar-icon-only {
            display: none;
        }
        .sidebar-hover:hover .sidebar-full {
            display: flex;
        }
    </style>
</head>
<body class="flex bg-gray-100">
    <!-- Sidebar izquierdo -->
    <div class="sidebar-hover fixed inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out">
        <div class="sidebar-content flex flex-col w-16 h-full overflow-hidden text-gray-400 bg-gray-900 transition-all duration-300">
            <a class="flex items-center justify-center h-16 bg-gray-800" href="#">
                <svg class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                </svg>
            </a>
            <div class="flex flex-col flex-grow">
                <nav class="flex-grow">
                    <ul class="flex flex-col py-4 space-y-1">
                        <li class="px-4">
                            <a href="#" class="flex items-center h-10 px-3 text-gray-400 transition-colors duration-300 ease-in-out hover:bg-gray-700 hover:text-white rounded-lg">
                                <span class="sidebar-icon-only">
                                    <i class='bx bxs-dashboard w-6 h-6 text-1xl scale-150'></i>
                                </span>
                                <span class="ml-3 sidebar-full hidden">Inicio</span>
                            </a>
                        </li>
                        <li class="px-4">
                            <a href="CRUDadmin.php" class="flex items-center h-10 px-3 text-gray-400 transition-colors duration-300 ease-in-out hover:bg-gray-700 hover:text-white rounded-lg">
                                <span class="sidebar-icon-only">
                                    <i class='bx bx-data w-8 h-6 text-1xl scale-150'></i>
                                </span>
                                <span class="ml-3 sidebar-full hidden">CRUD</span>
                            </a>
                        </li>
                        <li class="px-4">
                            <a href="#" class="flex items-center h-10 px-3 text-gray-400 transition-colors duration-300 ease-in-out hover:bg-gray-700 hover:text-white rounded-lg">
                                <span class="sidebar-icon-only">
                                    <i class='bx bx-line-chart w-8 h-6 text-1xl scale-150'></i>
                                </span>
                                <span class="ml-3 sidebar-full hidden text-auto">Informes Financieros</span>
                            </a>
                        </li>
                        <li class="px-4">
                            <a href="#" class="flex items-center h-10 px-3 text-gray-400 transition-colors duration-300 ease-in-out hover:bg-gray-700 hover:text-white rounded-lg">
                                <span class="sidebar-icon-only">
                                    <i class='bx bx-group w-8 h-6 text-1xl scale-150'></i>
                                </span>
                                <span class="ml-3 sidebar-full hidden d-flex">Cuentas de Proveedores</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="flex-1 ml-16">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
            </div>
        </header>
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Agrega tu contenido principal aquí -->
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96"></div>
            </div>
        </main>
    </div>

    <!-- Sidebar derecho -->
    <div class="fixed inset-y-0 right-0 z-30 w-64 bg-gray-800 text-white">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-4 h-16 bg-gray-700">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="text-lg font-semibold">Admin <?php echo $_SESSION['nombre']; ?></span>
                </div>
            </div>
            <div class="flex-grow"></div>
            <div class="p-4">
                <form method="POST">
                    <button type="submit" name="cerrar_sesion" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>