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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }
        .room-card {
            transition: all 0.3s ease;
        }
        .room-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar Izquierdo -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-xl font-bold text-gray-800">Hotel Deja Vu</h2>
            </div>
            <nav class="mt-4">
                <a href="indexRecepcion.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 active:bg-gray-200">
                    <i class='bx bx-grid-alt text-xl mr-3'></i>
                    Habitaciones
                </a>
                <a href="checkout.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100">
                    <i class='bx bx-log-out-circle text-xl mr-3'></i>
                    Check-out
                </a>
            </nav>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Panel de Control</h1>
                <div class="flex items-center gap-4">
                    <span class="text-gray-600"><?php echo $_SESSION['nombre']; ?></span>
                    <button id="toggleSidebar" class="p-2 rounded-full hover:bg-gray-100">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                </div>
            </header>

            <!-- Grid de Habitaciones -->
            <div class="bento-grid">
                <?php while($row = $result->fetch_assoc()): 
                    $statusClass = match($row['estado']) {
                        'disponible' => 'bg-green-100 border-green-500 text-green-700',
                        'reservada' => 'bg-blue-100 border-blue-500 text-blue-700',
                        'ocupada' => 'bg-red-100 border-red-500 text-red-700',
                        default => 'bg-gray-100 border-gray-500 text-gray-700'
                    };
                ?>
                <div class="room-card p-4 rounded-xl border-2 <?php echo $statusClass; ?> hover:shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold">Habitación <?php echo $row['numero_habitacion']; ?></h3>
                        <div class="flex gap-2">
                            <button onclick="cambiarEstado(<?php echo $row['id_habitacion']; ?>)" 
                                    class="p-2 rounded-full hover:bg-white/50">
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
        <div id="rightSidebar" class="w-64 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class='bx bx-user text-2xl text-gray-600'></i>
                    </div>
                    <div>
                        <h3 class="font-bold"><?php echo $_SESSION['nombre']; ?></h3>
                        <p class="text-sm text-gray-600">Recepcionista</p>
                    </div>
                </div>
                <form action="../../logout.php" method="POST">
                    <button type="submit" name="cerrar_sesion" id="cerrar_sesion" class="w-full px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                        Cerrar Sesión
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