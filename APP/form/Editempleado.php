<?php 
include __DIR__ . '../../config/conexion.php';

$id_empleado = $_GET['id_empleado'];

$sql = $conexion->query("SELECT * FROM empleados WHERE id_empleado='$id_empleado'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Editar empleado</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center p-5">
    <div class="w-full max-w-md">
        <a href="javascript:history.back()" class="mb-4 inline-flex items-center text-white hover:text-gray-200 transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form method="POST" class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-bold text-white mb-6 text-center">Editar empleado</h3>
            <input type="hidden" name="id_empleado" value="<?= $id_empleado ?>">
            <?php 
            include("../models/modEmpleado.php");
            while($huesped = $sql->fetch_assoc()) { ?>
            <div class="space-y-4">
                <div>
                    <label for="nombre" class="block text-gray-200 mb-1">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" value="<?php echo htmlspecialchars($huesped['nombre'] ?? ''); ?>">
                </div>
                <div>
                    <label for="apellido" class="block text-gray-200 mb-1">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" value="<?php echo htmlspecialchars($huesped['apellido'] ?? ''); ?>">
                </div>
                <div>
                    <label for="documento" class="block text-gray-200 mb-1">Documento:</label>
                    <input type="number" name="documento" id="documento" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" value="<?php echo htmlspecialchars($huesped['documento'] ?? ''); ?>">
                </div>
                <div>
                    <label for="telefono" class="block text-gray-200 mb-1">Teléfono:</label>
                    <input type="tel" name="telefono" id="telefono" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" value="<?php echo htmlspecialchars($huesped['telefono'] ?? ''); ?>">
                </div>
                <div>
                    <label for="correo" class="block text-gray-200 mb-1">Correo:</label>
                    <input type="email" name="correo" id="correo" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" value="<?php echo htmlspecialchars($huesped['correo'] ?? ''); ?>">
                </div>
                <div class="relative">
                    <label for="passwordInput" class="block text-gray-200 mb-1">Nueva Contraseña</label>
                    <input type="password" name="password" id="passwordInput" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 pr-10">
                    <i class='bx bx-hide absolute right-3 top-9 text-white cursor-pointer' id="togglePassword"></i>
                </div>
                <div>
                    <label for="horario" class="block text-gray-200 mb-1">horario:</label>
                    <input type="datetime-local" name="horario" id="horario" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="cargo" class="block text-gray-200 mb-1">Cargo:</label>
                    <input type="number" name="cargo" id="cargo" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-6 transition-colors flex items-center justify-center">
                <i class='bx bx-edit mr-2'></i> Actualizar
            </button>
        </form>
    </div>
    <?php }
      ?>
    <script src="../../public/js/script1.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transform = 'translateY(0)';
                }, 100);
                setTimeout(() => {
                    successMessage.style.transform = 'translateY(-100%)';
                }, 5000);
            }
        });
    </script>
</body>
</html>