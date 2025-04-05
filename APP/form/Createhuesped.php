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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Crear Huésped - Hotel Deja Vu</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'coral': '#ff7f50',
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
<body class="min-h-screen bg-primary font-montserrat text-white">
    <?php echo $mensaje; ?>
    <div class="w-full max-w-md mx-auto pt-16 pb-8 px-4">
        <a href="javascript:history.back()" class="mb-6 inline-flex items-center text-white hover:text-coral transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl mr-2'></i> Volver
        </a>
        <form action="" method="post" class="bg-white/10 backdrop-blur-lg rounded-xl shadow-lg p-8">
            <h3 class="text-3xl font-playfair font-bold text-white mb-6 text-center">Agregar Huésped</h3>

            <div class="space-y-4">
                <div>
                    <label for="nombre" class="block text-white mb-1 font-medium">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral">
                </div>
                <div>
                    <label for="apellido" class="block text-white mb-1 font-medium">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral">
                </div>
                <div>
                    <label for="documento" class="block text-white mb-1 font-medium">Documento:</label>
                    <input type="number" name="documento" id="documento" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral">
                </div>
                <div>
                    <label for="telefono" class="block text-white mb-1 font-medium">Teléfono:</label>
                    <input type="tel" name="telefono" id="telefono" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral">
                </div>
                <div>
                    <label for="nacionalidad" class="block text-white mb-1 font-medium">Nacionalidad:</label>
                    <input type="text" name="nacionalidad" id="nacionalidad" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral">
                </div>
                <div>
                    <label for="correo" class="block text-white mb-1 font-medium">Correo:</label>
                    <input type="email" name="correo" id="correo" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral">
                </div>
                <div class="relative">
                    <label for="passwordInput" class="block text-white mb-1 font-medium">Contraseña:</label>
                    <input type="password" name="password" id="passwordInput" required class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-coral pr-10">
                    <i class='bx bx-hide absolute right-3 top-9 text-white cursor-pointer' id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" name="enviar" value="ok" class="w-full bg-coral text-primary font-bold py-3 px-4 rounded-xl hover:bg-coral/80 transition-colors mt-6 flex items-center justify-center">
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