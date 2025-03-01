<?php 
include __DIR__ . '/../config/conexion.php';
session_start();
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 4) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_reporte'])) {
    $tipo_problema = $_POST['tipo_problema'];
    $descripcion = $_POST['descripcion'];
    $id_empleado = $_SESSION['id_empleado'];
    
    $query = "INSERT INTO reportes_mantenimiento (id_empleado, tipo_problema, descripcion) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("iss", $id_empleado, $tipo_problema, $descripcion);
    
    if ($stmt->execute()) {
        $mensaje = "Reporte enviado correctamente";
        $tipo_alerta = "success";
    } else {
        $mensaje = "Error al enviar el reporte: " . $conexion->error;
        $tipo_alerta = "error";
    }
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
    <title>Reportar Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #1a5c3a 0%, #2c8c5e 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .report-container {
            background-color: rgba(30, 41, 59, 0.9);
            border: 3px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .bento-item {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        .bento-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-white">
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="../../APP/views/indexAseo.php" class="text-white hover:text-green-400 transition duration-300">
                    <i class="fas fa-arrow-left text-2xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-white">Reportes de Mantenimiento</h1>
                <button id="sidebarToggle" class="text-white hover:text-green-400 transition duration-300">
                <i class="fas fa-user text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="report-container rounded-xl p-8 w-full max-w-4xl">
            <?php if (isset($mensaje)): ?>
                <div class="mb-6 p-4 rounded-lg <?php echo $tipo_alerta === 'success' ? 'bg-green-500' : 'bg-red-500'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
            
            <h2 class="text-4xl font-bold mb-8 text-center text-green-400">Reportar Problema de Mantenimiento</h2>
            
            <form method="POST" class="space-y-8">
                <div class="bento-grid">
                    <div class="bento-item">
                        <h3 class="text-xl font-semibold mb-4 text-green-300">Tipo de Problema</h3>
                        <select name="tipo_problema" required class="w-full px-4 py-3 bg-gray-700 text-white border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                            <option value="" disabled selected>Seleccione el tipo de problema</option>
                            <option value="Eléctrico">Eléctrico</option>
                            <option value="Fontanería">Fontanería</option>
                            <option value="Climatización">Climatización</option>
                            <option value="Pinturas y Acabados">Pinturas y Acabados</option>
                            <option value="Mantenimiento de Infraestructura">Mantenimiento de Infraestructura</option>
                            <option value="Seguridad y Prevención de Riesgos">Seguridad y Prevención de Riesgos</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    
                    <div class="bento-item">
                        <h3 class="text-xl font-semibold mb-4 text-green-300">Ubicación</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Área</label>
                                <select name="area" class="w-full px-4 py-3 bg-gray-700 text-white border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                                    <option value="Habitación">Habitación</option>
                                    <option value="Pasillo">Pasillo</option>
                                    <option value="Lobby">Lobby</option>
                                    <option value="Restaurante">Restaurante</option>
                                    <option value="Piscina">Piscina</option>
                                    <option value="Baño Público">Baño Público</option>
                                    <option value="Otra">Otra</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Número/Identificador</label>
                                <input type="text" name="identificador" placeholder="Ej: 101, Piso 2, etc." class="w-full px-4 py-3 bg-gray-700 text-white border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bento-item">
                    <h3 class="text-xl font-semibold mb-4 text-green-300">Descripción del Problema</h3>
                    <textarea name="descripcion" rows="5" required placeholder="Describa detalladamente el problema que necesita ser reparado..." aria-label="Descripción del problema" class="w-full px-4 py-3 bg-gray-700 text-white border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300"></textarea>
                </div>
                
                <div class="bento-item">
                    <h3 class="text-xl font-semibold mb-4 text-green-300">Prioridad</h3>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="prioridad" value="baja" class="form-radio text-green-500">
                            <span>Baja</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="prioridad" value="media" class="form-radio text-yellow-500" checked>
                            <span>Media</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="prioridad" value="alta" class="form-radio text-red-500">
                            <span>Alta</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-center">
                    <button type="submit" name="enviar_reporte" class="bg-green-500 text-white px-8 py-4 rounded-full hover:bg-green-600 transition duration-300 text-lg font-semibold flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Reporte
                    </button>
                </div>
            </form>
        </div>
    </main>

    <div id="sidebar" class="fixed top-0 right-0 w-64 h-full bg-gray-800 text-white transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-4 h-16 bg-gray-700">
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-3xl mr-2"></i>
                    <span class="text-lg font-semibold">Aseador <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                </div>
                <button onclick="toggleSidebar()" class="text-white hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="flex-grow"></div>
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