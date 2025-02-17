<?php 
include __DIR__ . '/../config/conexion.php';
session_start();
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 4) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// Función para obtener todas las tareas del empleado actual
function obtenerTareas($conexion, $id_empleado) {
    $query = "SELECT * FROM tareas WHERE id_empleado = ? ORDER BY estado, fecha_creacion DESC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

// Manejo de operaciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'agregar':
                $descripcion = $_POST['descripcion'];
                $query = "INSERT INTO tareas (id_empleado, descripcion) VALUES (?, ?)";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("is", $_SESSION['id_empleado'], $descripcion);
                $stmt->execute();
                break;
            case 'completar':
                $id_tarea = $_POST['id_tarea'];
                $query = "UPDATE tareas SET estado = 'completada', fecha_completada = CURRENT_TIMESTAMP WHERE id_tarea = ? AND id_empleado = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("ii", $id_tarea, $_SESSION['id_empleado']);
                $stmt->execute();
                break;
            case 'eliminar':
                $id_tarea = $_POST['id_tarea'];
                $query = "DELETE FROM tareas WHERE id_tarea = ? AND id_empleado = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("ii", $id_tarea, $_SESSION['id_empleado']);
                $stmt->execute();
                break;
        }
        // Redirigir para evitar reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$tareas = obtenerTareas($conexion, $_SESSION['id_empleado']);

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
    <title>Panel de Aseo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../public/images/logo1.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #1a5c3a 0%, #2c8c5e 100%);
        }
        .todo-container {
            background-color: rgba(30, 41, 59, 0.9);
            border: 3px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
        .task-item {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        @media (max-width: 640px) {
            .todo-container {
                width: 95%;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-white">
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="relative group">
                    <button class="text-white hover:text-green-400 transition duration-300">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-gray-700 rounded-md overflow-hidden shadow-xl z-10 hidden group-hover:block">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600">Reportes de Mantenimiento</a>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white">Panel de Aseo</h1>
                <button id="sidebarToggle" class="text-white hover:text-green-400 transition duration-300">
                    <i class="fas fa-user text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="todo-container rounded-xl p-8 w-full max-w-4xl">
            <h2 class="text-4xl font-bold mb-8 text-center text-green-400">Lista de Tareas</h2>
            <div class="space-y-8">
                <div>
                    <h3 class="text-2xl font-semibold mb-4 text-green-300">Tareas Realizadas</h3>
                    <ul id="completedTasks" class="space-y-3">
                        <?php foreach ($tareas as $tarea): ?>
                            <?php if ($tarea['estado'] === 'completada'): ?>
                                <li class="task-item flex items-center justify-between p-4 rounded-lg">
                                    <span class="text-gray-400 line-through text-lg"><?php echo htmlspecialchars($tarea['descripcion']); ?></span>
                                    <div class="flex items-center space-x-2">
                                        <form method="POST">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">
                                            <button type="submit" class="text-red-400 hover:text-red-600">
                                                <i class="fas fa-trash text-xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-4 text-green-300">Tareas Pendientes</h3>
                    <ul id="pendingTasks" class="space-y-3">
                        <?php foreach ($tareas as $tarea): ?>
                            <?php if ($tarea['estado'] === 'pendiente'): ?>
                                <li class="task-item flex items-center justify-between p-4 rounded-lg">
                                    <span class="text-white text-lg"><?php echo htmlspecialchars($tarea['descripcion']); ?></span>
                                    <div class="flex items-center space-x-2">
                                        <form method="POST" class="mr-2">
                                            <input type="hidden" name="accion" value="completar">
                                            <input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">
                                            <button type="submit" class="text-green-400 hover:text-green-600">
                                                <i class="fas fa-check text-xl"></i>
                                            </button>
                                        </form>
                                        <form method="POST">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">
                                            <button type="submit" class="text-red-400 hover:text-red-600">
                                                <i class="fas fa-trash text-xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-6">
                        <form method="POST" class="flex flex-col space-y-3">
                            <input type="hidden" name="accion" value="agregar">
                            <input type="text" name="descripcion" placeholder="Nueva tarea" required
                                   class="w-full px-4 py-3 bg-gray-700 text-white border-2 border-green-400 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300">
                            <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-full hover:bg-green-600 transition duration-300 w-1/2 text-lg font-semibold">
                                Agregar Tarea
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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