<?php 
include '../controllers/encriptar_desencriptar.php';
include __DIR__ . '../../config/conexion.php';

$mensaje = '';

if (isset($_POST['enviar'])) 
{
    if (
        isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['apellido']) && !empty($_POST['apellido']) &&
        isset($_POST['documento']) && !empty($_POST['documento']) &&
        isset($_POST['telefono']) && !empty($_POST['telefono']) &&
        isset($_POST['nacionalidad']) && !empty($_POST['nacionalidad']) &&
        isset($_POST['correo']) && !empty($_POST['correo']) &&
        isset($_POST['password']) && !empty($_POST['password'])
    ) {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
        $documento = mysqli_real_escape_string($conexion, $_POST['documento']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $nacionalidad = mysqli_real_escape_string($conexion, $_POST['nacionalidad']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);

        $encriptarDesencriptar = new EncriptarDesencriptar();
        $clave = "d3j4vu_H0t3l";

        $password = $encriptarDesencriptar->encrypt($_POST['password'], $clave);

        $sql = "INSERT INTO huespedes (nombre, apellido, documento, telefono, nacionalidad, correo, contraseña)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $apellido, $documento, $telefono, $nacionalidad, $correo, $password);
        
        if ($stmt->execute()) {
            $mensaje = '<div id="successMessage" class="fixed top-0 left-0 right-0 bg-green-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">Registro exitoso</div>';
        } else {
            $mensaje = '<div class="fixed top-0 left-0 right-0 bg-red-500 text-white p-4 text-center">Error al registrar: ' . $stmt->error . '</div>';
        }
        
        $stmt->close();
    } else {
        $mensaje = '<div class="fixed top-0 left-0 right-0 bg-yellow-500 text-white p-4 text-center">Todos los campos son obligatorios</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Crear Huésped</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-400 via-blue-600 to-gray-800 flex items-center justify-center p-5">
    <?php echo $mensaje; ?>
    <div class="w-full max-w-md">
        <a href="javascript:history.back()" class="mb-4 inline-flex items-center text-white hover:text-gray-200 transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form action="" method="post" class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-bold text-white mb-6 text-center">Agregar huéspedes</h3>

            <div class="space-y-4">
                <div>
                    <label for="nombre" class="block text-gray-200 mb-1">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="apellido" class="block text-gray-200 mb-1">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="documento" class="block text-gray-200 mb-1">Documento:</label>
                    <input type="number" name="documento" id="documento" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="telefono" class="block text-gray-200 mb-1">Teléfono:</label>
                    <input type="tel" name="telefono" id="telefono" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="nacionalidad" class="block text-gray-200 mb-1">Nacionalidad:</label>
                    <input type="text" name="nacionalidad" id="nacionalidad" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="correo" class="block text-gray-200 mb-1">Correo:</label>
                    <input type="email" name="correo" id="correo" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div class="relative">
                    <label for="passwordInput" class="block text-gray-200 mb-1">Contraseña:</label>
                    <input type="password" name="password" id="passwordInput" required class="w-full px-4 py-2 rounded-lg bg-blue-100 bg-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 pr-10">
                    <i class='bx bx-hide absolute right-3 top-9 text-white cursor-pointer' id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mt-6 transition-colors flex items-center justify-center">
                <i class='bx bx-plus-circle mr-2'></i> Agregar
            </button>
        </form>
    </div>
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