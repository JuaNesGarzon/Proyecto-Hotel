<?php 
include __DIR__ . '/../config/conexion.php';
session_start();
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 3) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// Función para obtener reportes de mantenimiento
function obtenerReportes($conexion, $estado = null) {
    $query = "SELECT r.*, e.nombre, e.apellido FROM reportes_mantenimiento r 
              JOIN empleados e ON r.id_empleado = e.id_empleado";
    
    if ($estado) {
        $query .= " WHERE r.estado = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $estado);
    } else {
        $stmt = $conexion->prepare($query);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

// Manejar completar reporte
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['completar_reporte'])) {
        $id_reporte = $_POST['id_reporte'];
        $query = "UPDATE reportes_mantenimiento SET estado = 'completado', fecha_completado = CURRENT_TIMESTAMP WHERE id_reporte = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_reporte);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$reportesPendientes = obtenerReportes($conexion, 'pendiente');
$reportesCompletados = obtenerReportes($conexion, 'completado');

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
    <title>Panel de Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(120deg, #1e3a8a 0%, #3b82f6 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .bento-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .bento-box {
            background-color: rgba(15, 23, 42, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        .bento-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        .report-card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }
        .report-card:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
        }
        .badge-pending {
            background-color: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }
        .badge-completed {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }
        .type-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-white">
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-tools text-3xl text-blue-400 mr-3"></i>
                    <h1 class="text-3xl font-bold text-white">Panel de Mantenimiento</h1>
                </div>
                <button id="sidebarToggle" class="text-white hover:text-blue-400 transition duration-300">
                    <i class="fas fa-user text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="flex-grow p-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Panel de Reportes Pendientes -->
                <div class="bento-box">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-blue-400">
                            <i class="fas fa-clipboard-list mr-2"></i>Reportes Pendientes
                        </h2>
                        <span class="badge badge-pending"><?php echo count($reportesPendientes); ?> pendientes</span>
                    </div>
                    
                    <div class="space-y-4 max-h-[calc(100vh-200px)] overflow-y-auto pr-2">
                        <?php if (empty($reportesPendientes)): ?>
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-check-circle text-4xl mb-3"></i>
                                <p>No hay reportes pendientes</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($reportesPendientes as $reporte): ?>
                                <div class="report-card p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="type-icon">
                                            <?php
                                            $icon = 'fa-bolt'; // Default: Eléctrico
                                            switch ($reporte['tipo_problema']) {
                                                case 'Fontanería':
                                                    $icon = 'fa-faucet';
                                                    break;
                                                case 'Climatización':
                                                    $icon = 'fa-temperature-low';
                                                    break;
                                                case 'Pinturas y Acabados':
                                                    $icon = 'fa-paint-roller';
                                                    break;
                                                case 'Mantenimiento de Infraestructura':
                                                    $icon = 'fa-hammer';
                                                    break;
                                                case 'Seguridad y Prevención de Riesgos':
                                                    $icon = 'fa-shield-alt';
                                                    break;
                                            }
                                            ?>
                                            <i class="fas <?php echo $icon; ?>"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($reporte['tipo_problema']); ?></h3>
                                                <span class="text-xs text-gray-400">
                                                    <?php echo date('d/m/Y H:i', strtotime($reporte['fecha_reporte'])); ?>
                                                </span>
                                            </div>
                                            <p class="text-gray-300 mt-1 text-sm"><?php echo htmlspecialchars($reporte['descripcion']); ?></p>
                                            <div class="flex justify-between items-center mt-3">
                                                <span class="text-xs text-gray-400">
                                                    Reportado por: <?php echo htmlspecialchars($reporte['nombre'] . ' ' . $reporte['apellido']); ?>
                                                </span>
                                                <form method="POST">
                                                    <input type="hidden" name="id_reporte" value="<?php echo $reporte['id_reporte']; ?>">
                                                    <button type="submit" name="completar_reporte" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded-full transition duration-300">
                                                        <i class="fas fa-check mr-1"></i> Completar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Panel de Reportes Completados -->
                <div class="bento-box">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-green-400">
                            <i class="fas fa-check-circle mr-2"></i>Reportes Completados
                        </h2>
                        <span class="badge badge-completed"><?php echo count($reportesCompletados); ?> completados</span>
                    </div>
                    
                    <div class="space-y-4 max-h-[calc(100vh-200px)] overflow-y-auto pr-2">
                        <?php if (empty($reportesCompletados)): ?>
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-clipboard-list text-4xl mb-3"></i>
                                <p>No hay reportes completados</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($reportesCompletados as $reporte): ?>
                                <div class="report-card p-4 opacity-80">
                                    <div class="flex items-start gap-3">
                                        <div class="type-icon bg-green-900/20 text-green-400">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($reporte['tipo_problema']); ?></h3>
                                                <div class="text-xs text-gray-400 text-right">
                                                    <div>Reportado: <?php echo date('d/m/Y', strtotime($reporte['fecha_reporte'])); ?></div>
                                                    <div>Completado: <?php echo date('d/m/Y', strtotime($reporte['fecha_completado'])); ?></div>
                                                </div>
                                            </div>
                                            <p class="text-gray-300 mt-1 text-sm"><?php echo htmlspecialchars($reporte['descripcion']); ?></p>
                                            <div class="mt-3">
                                                <span class="text-xs text-gray-400">
                                                    Reportado por: <?php echo htmlspecialchars($reporte['nombre'] . ' ' . $reporte['apellido']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="sidebar" class="fixed top-0 right-0 w-64 h-full bg-gray-800 text-white transform translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-4 h-16 bg-gray-700">
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-3xl mr-2"></i>
                    <span class="text-lg font-semibold">Mantenimiento <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                </div>
                <button onclick="toggleSidebar()" class="text-white hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="flex-grow p-4">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2 text-blue-400">Estadísticas</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-700 p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold"><?php echo count($reportesPendientes); ?></div>
                            <div class="text-xs text-gray-400">Pendientes</div>
                        </div>
                        <div class="bg-gray-700 p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold"><?php echo count($reportesCompletados); ?></div>
                            <div class="text-xs text-gray-400">Completados</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
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
        // Funcionalidad para el sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('translate-x-full');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>