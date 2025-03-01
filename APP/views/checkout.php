<?php
session_start();
include '../../APP/config/conexion.php';

if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 2) {
    header("Location: login.php");
    exit();
}

// Obtener huéspedes con reservas activas
$sql = "SELECT h.*, r.id_reserva, r.fecha_inicio, r.fecha_salida, hab.numero_habitacion, 
        GROUP_CONCAT(s.nombreServicio) as servicios,
        SUM(rs.costo_total) as total_servicios
        FROM huespedes h
        JOIN reservas r ON h.id_huesped = r.id_huesped
        JOIN habitaciones hab ON r.id_reserva = hab.id_reserva
        LEFT JOIN reservaservicio rs ON r.id_reserva = rs.id_reserva
        LEFT JOIN servicios s ON rs.id_servicio = s.id_servicio
        WHERE r.estado = 'activa'
        GROUP BY r.id_reserva";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-out - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
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
                <a href="indexRecepcion.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100">
                    <i class='bx bx-grid-alt text-xl mr-3'></i>
                    Habitaciones
                </a>
                <a href="#" class="flex items-center px-4 py-3 bg-gray-100 text-gray-700">
                    <i class='bx bx-log-out-circle text-xl mr-3'></i>
                    Check-out
                </a>
            </nav>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-md p-4">
                <h1 class="text-2xl font-bold text-gray-800">Check-out de Huéspedes</h1>
            </header>

            <div class="p-6">
                <div class="grid gap-6">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold mb-2">
                                    <?php echo $row['nombre'] . ' ' . $row['apellido']; ?>
                                </h3>
                                <p class="text-gray-600">Habitación <?php echo $row['numero_habitacion']; ?></p>
                            </div>
                            <button onclick="realizarCheckout(<?php echo $row['id_reserva']; ?>)"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Realizar Check-out
                            </button>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold mb-2">Información del Huésped</h4>
                                <p>Documento: <?php echo $row['documento']; ?></p>
                                <p>Teléfono: <?php echo $row['telefono']; ?></p>
                                <p>Nacionalidad: <?php echo $row['nacionalidad']; ?></p>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-2">Detalles de la Estancia</h4>
                                <p>Check-in: <?php echo $row['fecha_inicio']; ?></p>
                                <p>Check-out: <?php echo $row['fecha_salida']; ?></p>
                                <p>Servicios: <?php echo $row['servicios'] ?: 'Ninguno'; ?></p>
                                <p>Total servicios: $<?php echo number_format($row['total_servicios'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function realizarCheckout(idReserva) {
            if (confirm('¿Está seguro de realizar el check-out?')) {
                fetch('procesar_checkout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_reserva=${idReserva}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al realizar el check-out');
                    }
                });
            }
        }
    </script>
</body>
</html>