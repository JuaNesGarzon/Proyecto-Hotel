<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id_reserva'])) {
    header("Location: login.php");
    exit();
}

$id_huesped = $_SESSION['user_id'];
$id_reserva = $_GET['id_reserva'];

// Obtener información del huésped
$sql_huesped = "SELECT * FROM huespedes WHERE id_huesped = $id_huesped";
$result_huesped = $conexion->query($sql_huesped);
$huesped = $result_huesped->fetch_assoc();

// Obtener información de la reserva
$sql_reserva = "SELECT * FROM reservas WHERE id_reserva = $id_reserva AND id_huesped = $id_huesped";
$result_reserva = $conexion->query($sql_reserva);
$reserva = $result_reserva->fetch_assoc();

if (!$reserva) {
    echo "Reserva no encontrada";
    exit();
}

// Obtener servicios adicionales
$sql_servicios = "SELECT s.nombreServicio, rs.costo_total 
                  FROM reservaservicio rs 
                  JOIN servicios s ON rs.id_servicio = s.id_servicio 
                  WHERE rs.id_reserva = $id_reserva";
$result_servicios = $conexion->query($sql_servicios);

// Calcular costo total
$costo_total = 0;
$servicios = [];
while ($servicio = $result_servicios->fetch_assoc()) {
    $costo_total += $servicio['costo_total'];
    $servicios[] = $servicio;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Reserva - Hotel Deja Vu</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-primary font-montserrat min-h-screen">
    <div class="container mx-auto mt-20 p-8">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-lg max-w-2xl mx-auto">
            <h1 class="text-3xl font-playfair font-bold text-white mb-6 text-center">Recibo de Reserva</h1>
            
            <div class="mb-6">
                <p class="text-white">(Asegúrese de tomar una captura de pantalla de este recibo para confirmar en el hotel)</p><br>
                <h2 class="text-xl font-semibold text-white mb-2">Información del Huésped</h2>
                <p class="text-white"><strong>Nombre:</strong> <?php echo $huesped['nombre'] . ' ' . $huesped['apellido']; ?></p>
                <p class="text-white"><strong>Documento:</strong> <?php echo $huesped['documento']; ?></p>
                <p class="text-white"><strong>Teléfono:</strong> <?php echo $huesped['telefono']; ?></p>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-2">Detalles de la Reserva</h2>
                <p class="text-white"><strong>Número de habitación:</strong> <?php echo $reserva['numero_habitacion']; ?></p>
                <p class="text-white"><strong>Fecha de llegada:</strong> <?php echo $reserva['fecha_inicio']; ?></p>
                <p class="text-white"><strong>Fecha de salida:</strong> <?php echo $reserva['fecha_salida']; ?></p>
                <p class="text-white"><strong>Número de huéspedes:</strong> <?php echo $reserva['numero_huespedes']; ?></p>
                <p class="text-white"><strong>Tipo de habitación:</strong> <?php echo $reserva['tipo_habitacion']; ?></p>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-2">Servicios Adicionales</h2>
                <?php if (!empty($servicios)): ?>
                    <ul class="list-disc list-inside text-white">
                        <?php foreach ($servicios as $servicio): ?>
                            <li><?php echo $servicio['nombreServicio']; ?>: $<?php echo number_format($servicio['costo_total'], 2); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-white">No se seleccionaron servicios adicionales.</p>
                <?php endif; ?>
            </div>

            <div class="mt-6 border-t border-white/20 pt-4">
                <p class="text-white text-xl font-semibold">Costo Total: $<?php echo number_format($costo_total, 2); ?></p>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="../../public/index.php" class="bg-white text-primary px-6 py-2 rounded-xl hover:bg-white/90 transition duration-300 font-semibold inline-block">Volver al Inicio</a>
    </div>
</body>
</html>