<?php 
include __DIR__ . '../../config/conexion.php';

$id_huesped = $_GET['id_huesped'];

$sql = $conexion->prepare("SELECT * FROM huespedes WHERE id_huesped=?");
$sql->bind_param("i", $id_huesped);
$sql->execute();
$result = $sql->get_result();
$huesped = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Editar Huésped</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center p-5">
    <?php
    if (isset($_GET['success'])) {
        echo '<div id="successMessage" class="fixed top-0 left-0 right-0 bg-green-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">Modificación exitosa</div>';
    }
    if (isset($_GET['error'])) {
        $error = $_GET['error'] == 'campos_vacios' ? 'Todos los campos son obligatorios excepto la contraseña' : $_GET['error'];
        echo '<div id="errorMessage" class="fixed top-0 left-0 right-0 bg-red-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">' . htmlspecialchars($error) . '</div>';
    }
    ?>
    <div class="w-full max-w-md">
        <a href="javascript:history.back()" class="mb-4 inline-flex items-center text-white hover:text-gray-200 transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form method="POST" action="../models/modHuesped.php" class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-bold text-white mb-6 text-center">Editar huésped</h3>
            <input type="hidden" name="id_huesped" value="<?= $id_huesped ?>">
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
                    <label for="nacionalidad" class="block text-gray-200 mb-1">Nacionalidad:</label>
                    <input type="text" name="nacionalidad" id="nacionalidad" class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300" value="<?php echo htmlspecialchars($huesped['nacionalidad'] ?? ''); ?>">
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
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-6 transition-colors flex items-center justify-center">
                <i class='bx bx-edit mr-2'></i> Actualizar
            </button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            if (successMessage || errorMessage) {
                const message = successMessage || errorMessage;
                setTimeout(() => {
                    message.style.transform = 'translateY(0)';
                }, 100);
                setTimeout(() => {
                    message.style.transform = 'translateY(-100%)';
                }, 5000);
            }

            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('passwordInput');
            togglePassword.addEventListener('click', function (e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('bx-show');
            });
        });
    </script>
</body>
</html>