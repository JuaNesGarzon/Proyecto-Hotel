<?php
session_start();
include '../../APP/config/conexion.php';

// Verificar si el usuario es un empleado con rol de recepcionista
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 2) {
    header("Location: login.php");
    exit();
}

// Obtener todas las habitaciones
$sql = "SELECT * FROM habitaciones ORDER BY numero_habitacion";
$result = $conexion->query($sql);

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
    <title>Panel de Control - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
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
<body class="bg-primary font-montserrat text-white">
    <div class="flex h-screen">
        <!-- Sidebar Izquierdo -->
        <div class="w-64 bg-white/10 backdrop-blur-lg">
            <div class="p-4">
                <h2 class="text-xl font-playfair font-bold">Hotel Deja Vu</h2>
            </div>
            <nav class="mt-4">
                <a href="indexRecepcion.php" class="flex items-center px-4 py-3 text-white hover:bg-white/10 active:bg-white/20">
                    <i class='bx bx-grid-alt text-xl mr-3'></i>
                    Habitaciones
                </a>
            </nav>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white/10 backdrop-blur-lg p-4 flex justify-between items-center">
                <h1 class="text-2xl font-playfair font-bold">Panel de Control</h1>
                <div class="flex items-center gap-4">
                    <span class="text-white/90"><?php echo $_SESSION['nombre']; ?></span>
                    <button id="toggleSidebar" class="p-2 rounded-full hover:bg-white/10">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                </div>
            </header>
            
            <!-- Grid de Habitaciones -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                <?php while($row = $result->fetch_assoc()): 
                    $statusClass = match($row['estado']) {
                        'disponible' => 'bg-green-500/40 border-green-200/50 text-green-200',
                        'reservada' => 'bg-blue-500/40 border-blue-200/50 text-blue-200',
                        'ocupada' => 'bg-red-500/40 border-red-200/50 text-red-200',
                        default => 'bg-white/10 border-white/20 text-white/90'
                    };
                ?>
                <div class="p-4 rounded-2xl border-2 <?php echo $statusClass; ?> hover:scale-105 transition-all duration-300 backdrop-blur-lg">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold">Habitación <?php echo $row['numero_habitacion']; ?></h3>
                        <div class="flex gap-2">
                            <button onclick="cambiarEstado(<?php echo $row['id_habitacion']; ?>)" 
                                    class="p-2 rounded-full hover:bg-white/10">
                                 <i class='bx bx-refresh text-xl'></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm">Tipo: <?php echo ucfirst($row['tipo']); ?></p>
                        <p class="text-sm">Estado: <?php echo ucfirst($row['estado']); ?></p>
                        <p class="text-sm">Capacidad: <?php echo $row['numero_personas']; ?> personas</p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Sidebar Derecho -->
        <div id="rightSidebar" class="w-64 bg-white/10 backdrop-blur-lg transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class='bx bx-user text-2xl'></i>
                    </div>
                    <div>
                        <h3 class="font-bold"><?php echo $_SESSION['nombre']; ?></h3>
                        <p class="text-sm text-white/70">Recepcionista</p>
                    </div>
                </div>
                <form method="POST">
                    <button type="submit" name="cerrar_sesion" class="flex items-center justify-center w-full px-4 py-2 text-lg font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-sign-out-alt mr-2 text-xl"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle del sidebar derecho
        const toggleSidebar = document.getElementById('toggleSidebar');
        const rightSidebar = document.getElementById('rightSidebar');
        
        toggleSidebar.addEventListener('click', () => {
            rightSidebar.classList.toggle('translate-x-full');
        });

        // Función para cambiar el estado de una habitación
        function cambiarEstado(idHabitacion) {
            fetch('cambioEstado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_habitacion=${idHabitacion}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al cambiar el estado de la habitación');
                }
            });
        }
    </script>
</body>
</html>